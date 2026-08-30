<!-- ============ HEADER BANNER ============ -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-cyan-600 p-6 lg:p-7 mb-8 shadow-xl" data-aos="fade-down">
    <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-md">
                    <i class="fa-solid fa-business-time"></i>
                    <span>Shift Management</span>
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider backdrop-blur-md font-mono">
                    <?= count($data['assignments'] ?? []) ?> Assignments
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight font-outfit">
                Overtime <span class="gradient-text">Assignments</span>
            </h1>
            <p class="text-indigo-100 text-xs sm:text-sm mt-1">Schedule and manage overtime work shifts for individual staff or whole departments.</p>
        </div>
        <button onclick="openModal()" 
                class="px-5 py-2.5 rounded-xl bg-white text-indigo-700 hover:bg-slate-50 text-xs font-extrabold shadow-lg hover:scale-105 active:scale-95 transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus text-indigo-600"></i>
            <span>Assign Overtime</span>
        </button>
    </div>
</div>

<!-- ============ ERROR & SUCCESS ALERTS ============ -->
<?php 
$errorMsg = $data['error'] ?? $_GET['error'] ?? null;
if (!empty($errorMsg)): 
?>
    <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs font-semibold flex items-center gap-3 shadow-sm animate__animated animate__shakeX">
        <i class="fa-solid fa-circle-exclamation text-base text-rose-500"></i>
        <div>
            <span class="font-bold">Overtime Rule Violation:</span> <?= htmlspecialchars($errorMsg) ?>
        </div>
    </div>
<?php elseif(isset($_GET['msg'])): ?>
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs font-semibold flex items-center gap-3 shadow-sm" data-aos="fade-up">
        <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
        <div>
            <span class="font-bold">Success:</span> Overtime operation completed successfully.
        </div>
    </div>
<?php endif; ?>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-8" data-aos="fade-up" data-aos-delay="50">
    <!-- FILTER SECTION -->
    <div class="p-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row gap-4 items-center justify-between">
       
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-search text-slate-400 text-xs"></i>
                </div>
                <input type="text" id="filterName" placeholder="Search by name or ID..." class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 p-2.5 shadow-sm transition-all" onkeyup="filterTable()">
            </div>
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-building text-slate-400 text-xs"></i>
                </div>
                <select id="filterDept" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 p-2.5 shadow-sm transition-all appearance-none" onchange="filterTable()">
                    <option value="">All Departments</option>
                    <?php foreach($data['departments'] ?? [] as $dept): ?>
                        <option value="<?= htmlspecialchars($dept['DeptName']) ?>"><?= htmlspecialchars($dept['DeptName']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                </div>
            </div>
            <div class="relative w-full sm:w-48">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-calendar text-slate-400 text-xs"></i>
                </div>
                <input type="date" id="filterDate" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 p-2.5 shadow-sm transition-all" onchange="filterTable()">
            </div>
            <div class="relative w-full sm:w-48">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-calendar-day text-slate-400 text-xs"></i>
                </div>
                <select id="filterDayType" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 p-2.5 shadow-sm transition-all appearance-none" onchange="filterTable()">
                    <option value="">All Days</option>
                    <option value="Working Day">Working Day</option>
                    <option value="Weekend">Weekend</option>
                    <option value="Holiday">Holiday</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                </div>
            </div>
            <div class="relative w-full sm:w-48">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-circle-half-stroke text-slate-400 text-xs"></i>
                </div>
                <select id="filterStatus" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 p-2.5 shadow-sm transition-all appearance-none" onchange="filterTable()">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Assigned">Assigned</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="OT Full">OT Full</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="No OT">No OT</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-300">
            <thead class="text-xs uppercase bg-slate-50 dark:bg-slate-900/80 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700 font-bold tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 w-16">No.</th>
                    <th scope="col" class="px-6 py-4">Employee</th>
                    <th scope="col" class="px-6 py-4">Date</th>
                    <th scope="col" class="px-6 py-4">Time</th>
                    <th scope="col" class="px-6 py-4">Hours</th>
                    <th scope="col" class="px-6 py-4">Rate/Hr</th>
                    <th scope="col" class="px-6 py-4">Total Amount</th>
                    <th scope="col" class="px-6 py-4">Status</th>
                    <th scope="col" class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                <?php if(empty($data['assignments'])): ?>
                    <tr class="bg-white dark:bg-slate-800">
                        <td colspan="9" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            <div class="w-14 h-14 mx-auto bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-3 text-indigo-500">
                                <i class="fa-solid fa-business-time text-2xl"></i>
                            </div>
                            <p class="font-bold text-slate-900 dark:text-white text-sm">No overtime assignments found</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $count = 1; foreach($data['assignments'] as $ot): 
                        $otDate = $ot['OvertimeDate'];
                        $dayType = 'Working Day';
                        if (HolidayHelper::isPublicHoliday($otDate)) {
                            $dayType = 'Holiday';
                        } elseif (HolidayHelper::isWeekend($otDate)) {
                            $dayType = 'Weekend';
                        }
                    ?>
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition-colors group ot-row" data-name="<?= strtolower(htmlspecialchars($ot['FirstName'] . ' ' . $ot['LastName'] . ' emp-' . str_pad($ot['EmpID'], 4, '0', STR_PAD_LEFT))) ?>" data-dept="<?= htmlspecialchars($ot['DeptName'] ?? '') ?>" data-daytype="<?= $dayType ?>" data-status="<?= htmlspecialchars($ot['Status'] === 'NoOT' ? 'No OT' : ($ot['Status'] === 'InProgress' ? 'In Progress' : ($ot['Status'] ?? 'Pending'))) ?>" data-date="<?= htmlspecialchars($otDate) ?>">
                        <td class="px-6 py-3.5 font-bold text-slate-500 dark:text-slate-400 text-xs text-center"><?= $count++ ?></td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <?php if (!empty($ot['ProfilePicture'])): ?>
                                    <img src="/payrollsystem/assets/uploads/profiles/<?= htmlspecialchars($ot['ProfilePicture']) ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-sky-500 text-white flex items-center justify-center font-extrabold text-xs shadow-sm">
                                        <?= strtoupper(substr($ot['FirstName'],0,1) . substr($ot['LastName'],0,1)) ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white text-xs"><?= htmlspecialchars($ot['FirstName'] . ' ' . $ot['LastName']) ?></div>
                                    <div class="text-[11px] text-indigo-600 dark:text-sky-400 font-mono font-semibold">EMP-<?= str_pad($ot['EmpID'], 4, '0', STR_PAD_LEFT) ?> <span class="text-slate-400 dark:text-slate-500 ml-1 font-sans font-normal">• <?= htmlspecialchars($ot['DeptName'] ?? 'Unknown Dept') ?></span></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 font-semibold text-slate-900 dark:text-white text-xs">
                            <?= date('M j, Y', strtotime($ot['OvertimeDate'])) ?>
                            <div class="mt-1">
                                <?php if($dayType === 'Holiday'): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200 dark:bg-rose-950/50 dark:text-rose-400 dark:border-rose-800">Holiday</span>
                                <?php elseif($dayType === 'Weekend'): ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200 dark:bg-amber-950/50 dark:text-amber-400 dark:border-amber-800">Weekend</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 dark:bg-slate-700 dark:text-slate-400 dark:border-slate-600">Working Day</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 font-mono text-xs text-slate-700 dark:text-slate-300">
                            <?php if ($ot['StartTime'] && $ot['EndTime']): ?>
                                <?= date('h:i A', strtotime($ot['StartTime'])) ?> - <?= date('h:i A', strtotime($ot['EndTime'])) ?>
                            <?php else: ?>
                                <span class="text-slate-400 italic">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold font-mono bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800">
                                <?= $ot['TotalHours'] ?> Hrs
                            </span>
                        </td>
                        <td class="px-6 py-3.5 font-mono font-semibold text-xs text-slate-800 dark:text-slate-200">
                            <?= number_format($ot['RateMultiplier'], 1) ?>x
                        </td>
                        <td class="px-6 py-3.5 font-mono font-bold text-emerald-600 dark:text-emerald-400 text-xs">
                            <?= number_format($ot['OTAmount'], 2) ?> MMK
                        </td>
                        <td class="px-6 py-3.5">
                            <?php 
                                $statusColors = [
                                    'Pending' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
                                    'Assigned' => 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-950/50 dark:text-sky-300 dark:border-sky-800',
                                    'Accepted' => 'bg-indigo-50 text-indigo-700 border-indigo-200 dark:bg-indigo-950/50 dark:text-indigo-300 dark:border-indigo-800',
                                    'Rejected' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800',
                                    'InProgress' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
                                    'In Progress' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/50 dark:text-amber-300 dark:border-amber-800',
                                    'Completed' => 'bg-teal-50 text-teal-700 border-teal-200 dark:bg-teal-950/50 dark:text-teal-300 dark:border-teal-800',
                                    'Approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/50 dark:text-emerald-300 dark:border-emerald-800',
                                    'OT Full' => 'bg-fuchsia-50 text-fuchsia-700 border-fuchsia-200 dark:bg-fuchsia-950/50 dark:text-fuchsia-300 dark:border-fuchsia-800',
                                    'NoOT' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600',
                                    'No OT' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600',
                                    'No Show' => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600',
                                    'Cancelled' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950/50 dark:text-rose-300 dark:border-rose-800'
                                ];
                                $st = $ot['Status'] ?? 'Pending';
                                $colorClass = $statusColors[$st] ?? 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:border-slate-600';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border <?= $colorClass ?>">
                                <?php 
                                    if ($st === 'NoOT') echo 'No OT';
                                    elseif ($st === 'InProgress') echo 'In Progress';
                                    else echo htmlspecialchars($st);
                                ?>
                            </span>
                        </td>

                        <td class="px-6 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <?php if (($ot['Status'] ?? 'Pending') === 'Completed'): ?>
                                    <form action="/payrollsystem/admin/overtime_assignments" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Approve this completed overtime assignment?');">
                                        <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <input type="hidden" name="id" value="<?= $ot['OvertimeID'] ?>">
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:text-emerald-400 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center transition-colors shadow-sm" title="Approve Overtime">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <?php if (($ot['Status'] ?? 'Pending') === 'Pending'): ?>
                                <button onclick="editModal(<?= htmlspecialchars(json_encode($ot)) ?>)" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-400 dark:hover:bg-indigo-900/60 border border-indigo-200 dark:border-indigo-800 flex items-center justify-center transition-colors shadow-sm" title="Edit">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </button>
                                
                                <form action="/payrollsystem/admin/overtime_assignments" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Cancel this assignment?');">
                                    <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
                                    <input type="hidden" name="action" value="cancel">
                                    <input type="hidden" name="id" value="<?= $ot['OvertimeID'] ?>">
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-950/50 dark:text-rose-400 dark:hover:bg-rose-900/60 border border-rose-200 dark:border-rose-800 flex items-center justify-center transition-colors shadow-sm" title="Cancel">
                                        <i class="fa-solid fa-ban text-xs"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                                
                                <?php if (!in_array($ot['Status'] ?? 'Pending', ['Pending', 'Completed', 'Approved', 'OT Full'])): ?>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">View Only</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Modal -->
<div id="assignmentModal" class="hidden fixed inset-0 z-[100] overflow-y-auto bg-slate-950/70 backdrop-blur-sm flex items-center justify-center p-4 transition-all">
    <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700 transform transition-all animate__animated animate__fadeInUp">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-900/50">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white flex items-center gap-2 font-outfit" id="modalTitle">
                <i class="fa-solid fa-business-time text-indigo-500"></i> Assign Overtime
            </h3>
            <button type="button" onclick="closeModal()" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
        <form action="/payrollsystem/admin/overtime_assignments" method="POST" class="p-6">
            <input type="hidden" name="csrf_token" value="<?= $this->generateCsrfToken() ?>">
            <input type="hidden" name="action" id="formAction" value="add">
            <input type="hidden" name="id" id="assignment_id" value="">
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="assign_type" value="individual" checked onchange="toggleAssignType()" class="form-radio text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                        <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Individual Employee</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="assign_type" value="department" onchange="toggleAssignType()" class="form-radio text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                        <span class="ml-2 text-xs font-bold text-slate-700 dark:text-slate-300">Entire Department</span>
                    </label>
                </div>

                <div id="dept_container" class="hidden">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Select Department</label>
                    <select name="assign_dept_id" id="assign_dept_id" onchange="validateOT()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm cursor-pointer">
                        <option value="">Select a Department</option>
                        <?php foreach($data['departments'] as $dept): ?>
                            <option value="<?= $dept['DeptID'] ?>"><?= htmlspecialchars($dept['DeptName']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="emp_container">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Employee</label>
                    <select name="emp_id" id="emp_id" onchange="validateOT()" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm cursor-pointer">
                        <option value="">Select Employee</option>
                        <?php foreach($data['employees'] as $emp): ?>
                            <option value="<?= $emp['EmpID'] ?>" data-dept="<?= $emp['DeptID'] ?>"><?= htmlspecialchars($emp['FirstName'] . ' ' . $emp['LastName']) ?> (EMP-<?= str_pad($emp['EmpID'], 4, '0', STR_PAD_LEFT) ?>) <?= $emp['Status'] !== 'Active' ? '[Inactive]' : '' ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Date</label>
                    <input type="date" name="overtime_date" id="overtime_date" min="<?= date('Y-m-d') ?>" required onchange="calculateHoursAndAmount(); validateOT();" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm transition-all">
                    <p id="date_rule_hint" class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-circle-info text-indigo-500"></i>
                        <span>Select a date to view overtime hours rule.</span>
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Start Time</label>
                        <input type="time" name="start_time" id="start_time" required onchange="calculateHoursAndAmount(); validateOT();" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">End Time</label>
                        <input type="time" name="end_time" id="end_time" required onchange="calculateHoursAndAmount(); validateOT();" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm transition-all">
                    </div>
                </div>
                <div id="time_error" class="hidden p-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs font-bold flex items-start gap-2 animate__animated animate__fadeIn">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <span id="time_error_text"></span>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Total Hours</label>
                        <input type="number" step="0.1" name="hours" id="hours" readonly class="w-full px-3.5 py-2.5 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl text-xs font-mono font-bold shadow-inner">
                    </div>
                </div>
            </div>
            
            <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-700 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                    Cancel
                </button>
                <button type="submit" id="save_btn" class="px-5 py-2.5 text-xs font-extrabold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 rounded-xl shadow-lg shadow-indigo-500/25 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    Assign OT
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const fixedHolidays = ['01-04', '02-12', '03-02', '03-27', '05-01', '07-19', '12-25'];
    const dynamicHolidays = ['2026-04-13', '2026-04-14', '2026-04-15', '2026-04-16', '2026-04-17'];
    const allAssignments = <?= json_encode($data['assignments'] ?? []) ?>;
    const approvedLeaves = <?= json_encode($data['approvedLeaves'] ?? []) ?>;

    function isPublicHoliday(dateStr) {
        if (!dateStr) return false;
        const monthDay = dateStr.substring(5); // MM-DD
        return fixedHolidays.includes(monthDay) || dynamicHolidays.includes(dateStr);
    }

    function isWeekend(dateStr) {
        if (!dateStr) return false;
        const d = new Date(dateStr + 'T00:00:00');
        const day = d.getDay(); // 0 = Sunday, 6 = Saturday
        return day === 0 || day === 6;
    }

    function isWorkingDay(dateStr) {
        return !isWeekend(dateStr) && !isPublicHoliday(dateStr);
    }

    function toggleAssignType() {
        const type = document.querySelector('input[name="assign_type"]:checked').value;
        const empContainer = document.getElementById('emp_container');
        const deptContainer = document.getElementById('dept_container');
        const empSelect = document.getElementById('emp_id');
        const deptSelect = document.getElementById('assign_dept_id');
        
        if (type === 'department') {
            empContainer.classList.add('hidden');
            deptContainer.classList.remove('hidden');
            empSelect.removeAttribute('required');
            deptSelect.setAttribute('required', 'required');
        } else {
            empContainer.classList.remove('hidden');
            deptContainer.classList.add('hidden');
            deptSelect.removeAttribute('required');
            empSelect.setAttribute('required', 'required');
        }
        validateOT();
    }

    function calculateHoursAndAmount() {
        const startTimeStr = document.getElementById('start_time').value;
        const endTimeStr = document.getElementById('end_time').value;
        const hoursInput = document.getElementById('hours');
        
        if (startTimeStr && endTimeStr) {
            const start = new Date(`2000-01-01T${startTimeStr}`);
            let end = new Date(`2000-01-01T${endTimeStr}`);
            
            if (end < start) {
                end.setDate(end.getDate() + 1);
            }
            
            const diffMs = end - start;
            const diffHours = diffMs / (1000 * 60 * 60);
            
            hoursInput.value = diffHours > 0 ? diffHours.toFixed(2) : '0.00';
        } else {
            hoursInput.value = '';
        }
    }

    function validateOT() {
        const errorEl = document.getElementById('time_error');
        const errorText = document.getElementById('time_error_text');
        const saveBtn = document.getElementById('save_btn');
        const dateVal = document.getElementById('overtime_date').value;
        const startVal = document.getElementById('start_time').value;
        const endVal = document.getElementById('end_time').value;
        const empId = document.getElementById('emp_id').value;
        const currentId = document.getElementById('assignment_id').value;
        const type = document.querySelector('input[name="assign_type"]:checked').value;
        const dateHint = document.getElementById('date_rule_hint');
        
        errorEl.classList.add('hidden');
        errorText.innerText = '';
        saveBtn.disabled = false;

        if (!dateVal) {
            dateHint.innerHTML = `<i class="fa-solid fa-circle-info text-indigo-500"></i> <span>Select a date to view overtime hours rule.</span>`;
            return;
        }

        const now = new Date();
        const todayStr = now.getFullYear() + '-' + String(now.getMonth() + 1).padStart(2, '0') + '-' + String(now.getDate()).padStart(2, '0');
        const startTimeInput = document.getElementById('start_time');
        if (dateVal === todayStr) {
            const currentHourMinute = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            startTimeInput.min = currentHourMinute;
        } else {
            startTimeInput.removeAttribute('min');
        }

        const workingDay = isWorkingDay(dateVal);
        if (workingDay) {
            dateHint.innerHTML = `<i class="fa-solid fa-clock text-amber-500"></i> <span class="text-amber-600 dark:text-amber-400 font-bold">Working Day: Overtime strictly allowed from 5:00 PM (17:00) to 9:00 PM (21:00). Max 4h.</span>`;
        } else {
            dateHint.innerHTML = `<i class="fa-solid fa-calendar-check text-emerald-500"></i> <span class="text-emerald-600 dark:text-emerald-400 font-bold">Weekend / Holiday: Overtime strictly allowed from 9:00 AM (09:00) to 5:00 PM (17:00). Max 4h.</span>`;
        }

        // Leave Validation
        const deptId = document.getElementById('assign_dept_id').value;
        let empsToCheck = [];
        if (type === 'individual' && empId) {
            empsToCheck.push(empId);
        } else if (type === 'department' && deptId) {
            const empOptions = document.querySelectorAll('#emp_id option');
            empOptions.forEach(opt => {
                if (opt.getAttribute('data-dept') === deptId) {
                    empsToCheck.push(opt.value);
                }
            });
        }

        if (empsToCheck.length > 0 && dateVal) {
            for (let emp of empsToCheck) {
                const leave = approvedLeaves.find(l => l.EmpID == emp && dateVal >= l.StartDate && dateVal <= l.EndDate);
                if (leave) {
                    errorText.innerText = `Leave rule violation: ${type === 'department' ? 'An employee in this department' : 'This employee'} is on approved leave on ${dateVal}.`;
                    errorEl.classList.remove('hidden');
                    saveBtn.disabled = true;
                    return;
                }
            }
        }

        if (startVal) {
            const formAction = document.getElementById('formAction').value;
            const selectedDateTime = new Date(`${dateVal}T${startVal}:00`);
            if (formAction === 'add') {
                if (selectedDateTime < now) {
                    errorText.innerText = "Overtime assignment cannot be scheduled for a past date and time.";
                    errorEl.classList.remove('hidden');
                    saveBtn.disabled = true;
                    return;
                }
                const diffMs = selectedDateTime - now;
                if (diffMs < 3600000) { // 3600000 ms = 1 hour
                    errorText.innerText = "Overtime must be assigned at least 1 hour before the start time.";
                    errorEl.classList.remove('hidden');
                    saveBtn.disabled = true;
                    return;
                }
            }
        }

        if (!startVal || !endVal) return;

        // 1. Time Window Rule Check
        if (workingDay) {
            if (startVal < '17:00' || startVal > '21:00' || endVal > '21:00' || endVal < '17:00') {
                errorText.innerText = "Overtime rule violation: On working days, overtime is only allowed between 5:00 PM (17:00) and 9:00 PM (21:00).";
                errorEl.classList.remove('hidden');
                saveBtn.disabled = true;
                return;
            }
        } else {
            if (startVal < '09:00' || startVal > '17:00' || endVal > '17:00' || endVal < '09:00') {
                errorText.innerText = "Overtime rule violation: On weekends/holidays, overtime is only allowed between 9:00 AM (09:00) and 5:00 PM (17:00).";
                errorEl.classList.remove('hidden');
                saveBtn.disabled = true;
                return;
            }
        }

        // 2. Start and End time cannot be equal
        if (startVal === endVal) {
            errorText.innerText = "Invalid time range: Start time and End time cannot be the same.";
            errorEl.classList.remove('hidden');
            saveBtn.disabled = true;
            return;
        }

        // 3. End time must be after start time
        if (endVal < startVal) {
            errorText.innerText = "Invalid time range: End time must be after start time.";
            errorEl.classList.remove('hidden');
            saveBtn.disabled = true;
            return;
        }

        // 3. Duration Rules (Min 1 Hour, Max 4 Hours)
        const start = new Date(`2000-01-01T${startVal}`);
        let end = new Date(`2000-01-01T${endVal}`);
        const diffHours = (end - start) / (1000 * 60 * 60);
        
        if (diffHours < 1) {
            errorText.innerText = `Minimum overtime duration rule violated: Overtime must be at least 1 hour (Selected: ${diffHours.toFixed(1)} hrs).`;
            errorEl.classList.remove('hidden');
            saveBtn.disabled = true;
            return;
        }

        if (diffHours > 4) {
            errorText.innerText = `Daily overtime limit exceeded: Maximum allowed is 4 hours (Selected: ${diffHours.toFixed(1)} hrs).`;
            errorEl.classList.remove('hidden');
            saveBtn.disabled = true;
            return;
        }

        // 4. Overlap & Duplicate validation
        const startUnix = new Date(`1970-01-01T${startVal}`).getTime();
        let endUnix = new Date(`1970-01-01T${endVal}`).getTime();
        if (endUnix <= startUnix) endUnix += 86400000;

        if (empsToCheck.length > 0) {
            for (let ot of allAssignments) {
                if (empsToCheck.includes(ot.EmpID.toString()) && ot.OvertimeDate === dateVal && ot.OvertimeID != currentId && !['Cancelled', 'Rejected', 'NoOT', 'No OT', 'No Show'].includes(ot.Status)) {
                    if (!ot.StartTime || !ot.EndTime) continue;
                    const otStartTimeStr = ot.StartTime.includes(' ') ? ot.StartTime.split(' ')[1] : ot.StartTime;
                    const otEndTimeStr = ot.EndTime.includes(' ') ? ot.EndTime.split(' ')[1] : ot.EndTime;
                    const exStart = new Date(`1970-01-01T${otStartTimeStr}`).getTime();
                    let exEnd = new Date(`1970-01-01T${otEndTimeStr}`).getTime();
                    if (exEnd <= exStart) exEnd += 86400000;

                    if (startUnix < exEnd && endUnix > exStart) {
                        if (type === 'department') {
                            errorText.innerText = "Duplicate / Overlap rule violation: Overtime schedule overlaps with an existing assignment for staff in this department.";
                        } else {
                            errorText.innerText = "Duplicate / Overlap rule violation: This employee already has an overtime assignment during this time.";
                        }
                        errorEl.classList.remove('hidden');
                        saveBtn.disabled = true;
                        return;
                    }
                }
            }
        }
    }

    function openModal() {
        document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-clipboard-list text-indigo-500 mr-2"></i> Assign Overtime';
        document.getElementById('formAction').value = 'add';
        document.getElementById('assignment_id').value = '';
        document.querySelector('input[name="assign_type"][value="individual"]').checked = true;
        
        document.querySelectorAll('input[name="assign_type"]').forEach(el => el.disabled = false);
        
        toggleAssignType();
        document.getElementById('emp_id').value = '';
        document.getElementById('assign_dept_id').value = '';
        document.getElementById('overtime_date').value = '';
        document.getElementById('start_time').value = '';
        document.getElementById('end_time').value = '';
        document.getElementById('hours').value = '';
        document.getElementById('time_error').classList.add('hidden');
        document.getElementById('date_rule_hint').innerHTML = `<i class="fa-solid fa-circle-info text-indigo-500"></i> <span>Select a date to view overtime hours rule.</span>`;
        document.getElementById('save_btn').disabled = false;
        document.getElementById('assignmentModal').classList.remove('hidden');
    }

    function editModal(data) {
        document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-pen text-indigo-500 mr-2"></i> Edit Assignment';
        document.getElementById('formAction').value = 'edit';
        document.getElementById('assignment_id').value = data.OvertimeID;
        
        document.querySelector('input[name="assign_type"][value="individual"]').checked = true;
        document.querySelectorAll('input[name="assign_type"]').forEach(el => el.disabled = true);
        toggleAssignType();
        
        document.getElementById('emp_id').value = data.EmpID;
        document.getElementById('overtime_date').value = data.OvertimeDate;
        
        let startStr = '';
        if (data.StartTime) {
            startStr = data.StartTime.includes(' ') ? data.StartTime.split(' ')[1].substring(0, 5) : data.StartTime.substring(0, 5);
        }
        let endStr = '';
        if (data.EndTime) {
            endStr = data.EndTime.includes(' ') ? data.EndTime.split(' ')[1].substring(0, 5) : data.EndTime.substring(0, 5);
        }
        
        document.getElementById('start_time').value = startStr;
        document.getElementById('end_time').value = endStr;
        document.getElementById('hours').value = data.TotalHours;
        document.getElementById('time_error').classList.add('hidden');
        document.getElementById('save_btn').disabled = false;
        validateOT();
        document.getElementById('assignmentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('assignmentModal').classList.add('hidden');
    }

    function filterTable() {
        let nameFilter = document.getElementById('filterName').value.toLowerCase();
        let deptFilter = document.getElementById('filterDept').value;
        let dayTypeFilter = document.getElementById('filterDayType').value;
        let statusFilter = document.getElementById('filterStatus').value;
        let dateFilter = document.getElementById('filterDate').value;
        let rows = document.querySelectorAll('.ot-row');
        
        rows.forEach(row => {
            let nameAttr = row.getAttribute('data-name') || '';
            let deptAttr = row.getAttribute('data-dept') || '';
            let dayTypeAttr = row.getAttribute('data-daytype') || '';
            let statusAttr = row.getAttribute('data-status') || '';
            let dateAttr = row.getAttribute('data-date') || '';
            
            let nameMatch = nameFilter === '' || nameAttr.includes(nameFilter);
            let deptMatch = deptFilter === '' || deptAttr === deptFilter;
            let dayTypeMatch = dayTypeFilter === '' || dayTypeAttr === dayTypeFilter;
            let statusMatch = statusFilter === '' || statusAttr === statusFilter;
            let dateMatch = dateFilter === '' || dateAttr === dateFilter;
            
            if (nameMatch && deptMatch && dayTypeMatch && statusMatch && dateMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    <?php if(isset($_GET['assign_type_error']) && isset($_GET['error'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        openModal();
        
        // Hide the main alert at the top
        let mainAlerts = document.querySelectorAll('.animate__shakeX');
        mainAlerts.forEach(alert => alert.style.display = 'none');
        
        let errorType = <?= json_encode($_GET['assign_type_error']) ?>;
        let errorMessage = <?= json_encode($_GET['error']) ?>;
        
        // Switch to the correct assign type
        if (errorType === 'department') {
            document.querySelector('input[name="assign_type"][value="department"]').click();
        } else {
            document.querySelector('input[name="assign_type"][value="individual"]').click();
        }
        
        // Create error element
        let errorDiv = document.createElement('div');
        errorDiv.className = 'mt-2 p-2 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 text-[11px] font-bold flex items-start gap-2 animate__animated animate__fadeIn';
        errorDiv.innerHTML = '<i class="fa-solid fa-circle-exclamation mt-0.5"></i> <span>' + errorMessage + '</span>';
        
        // Append error to the correct container
        if (errorType === 'department') {
            document.getElementById('dept_container').appendChild(errorDiv);
        } else {
            document.getElementById('emp_container').appendChild(errorDiv);
        }
    });
    <?php endif; ?>
</script>
