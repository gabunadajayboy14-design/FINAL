<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYMARK — Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --accent: #0f172a;
            --accent-text: #ffffff;
            --shadow-card: 0 4px 6px -1px rgb(0 0 0 / 0.02);
        }

        .dark {
            --bg-primary: #09090b;
            --bg-secondary: #121215;
            --bg-card: #18181b;
            --border-color: #27272a;
            --border-hover: #3f3f46;
            --text-primary: #f4f4f5;
            --text-secondary: #a1a1aa;
            --accent: #f4f4f5;
            --accent-text: #09090b;
            --shadow-card: 0 4px 6px -1px rgb(0 0 0 / 0.2);
        }

        .clean-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-card);
            transition: all 0.2s ease;
        }
        .clean-card:hover {
            border-color: var(--border-hover);
        }

        .clean-input {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }
        .clean-input:focus {
            outline: none;
            border-color: var(--text-secondary);
            box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.15);
        }

        .primary-btn {
            background-color: var(--accent);
            color: var(--accent-text);
            transition: all 0.15s ease;
        }
        .primary-btn:hover {
            opacity: 0.9;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 9999px; }
    </style>
</head>
<body id="appBody" class="min-h-full flex flex-col lg:flex-row selection:bg-slate-500 selection:text-white">

    <!-- LEFT SIDEBAR NAVIGATION & QUICK STATS -->
    <aside class="w-full lg:w-80 border-b lg:border-b-0 lg:border-r border-[var(--border-color)] bg-[var(--bg-secondary)] flex flex-col justify-between p-6 shrink-0 lg:min-h-screen sticky top-0 z-40">
        <div>
            <!-- Header Identity -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[var(--accent)] text-[var(--accent-text)] flex items-center justify-center font-bold text-sm">
                        J
                    </div>
                    <div>
                        <h1 class="font-bold text-xs tracking-widest uppercase">GABUNADA</h1>
                        <p class="text-[10px] text-[var(--text-secondary)] font-medium">Split-Screen Workspace</p>
                    </div>
                </div>
                <button onclick="toggleDarkMode()" class="w-8 h-8 rounded-lg clean-input flex items-center justify-center text-xs text-[var(--text-secondary)] hover:text-[var(--text-primary)]" title="Toggle Theme">
                    <i id="themeIcon" class="fa-solid fa-moon"></i>
                </button>
            </div>

            <!-- Quick Metrics Overview -->
            <div class="grid grid-cols-3 gap-2 mb-6">
                <div class="clean-card rounded-xl p-3 text-center">
                    <p class="text-[9px] font-bold text-[var(--text-secondary)] uppercase">Total</p>
                    <h3 id="statTotal" class="text-lg font-bold mt-0.5">0</h3>
                </div>
                <div class="clean-card rounded-xl p-3 text-center">
                    <p class="text-[9px] font-bold text-[var(--text-secondary)] uppercase">Active</p>
                    <h3 id="statPending" class="text-lg font-bold mt-0.5 text-blue-600 dark:text-blue-400">0</h3>
                </div>
                <div class="clean-card rounded-xl p-3 text-center">
                    <p class="text-[9px] font-bold text-[var(--text-secondary)] uppercase">Done</p>
                    <h3 id="statCompleted" class="text-lg font-bold mt-0.5 text-emerald-600 dark:text-emerald-400">0</h3>
                </div>
            </div>

            <!-- Views / Filter Navigation -->
            <div class="space-y-1 mb-8">
                <p class="text-[10px] font-bold text-[var(--text-secondary)] uppercase tracking-wider mb-2 px-2">Navigation</p>
                <button onclick="setFilter('all')" id="tab-all" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all bg-[var(--accent)] text-[var(--accent-text)] shadow-sm">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-layer-group w-4 text-center"></i> All Tasks</span>
                    <span id="badge-all" class="text-[10px] opacity-80">0</span>
                </button>
                <button onclick="setFilter('pending')" id="tab-pending" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-spinner w-4 text-center"></i> In Progress</span>
                    <span id="badge-pending" class="text-[10px] opacity-80">0</span>
                </button>
                <button onclick="setFilter('completed')" id="tab-completed" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all">
                    <span class="flex items-center gap-2.5"><i class="fa-solid fa-check w-4 text-center"></i> Completed</span>
                    <span id="badge-completed" class="text-[10px] opacity-80">0</span>
                </button>
            </div>
        </div>

        <div class="text-[10px] text-[var(--text-secondary)] border-t border-[var(--border-color)] pt-4">
            <p>JAY BOY OS v2.0</p>
            <p class="mt-0.5">Optimized for productivity.</p>
        </div>
    </aside>

    <!-- RIGHT MAIN WORKSPACE (SPLIT INTO CREATOR & TASK LIST) -->
    <main class="flex-1 p-6 lg:p-10 max-w-6xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Column 1: Inline Task Creator Form (4 Columns) -->
        <section class="lg:col-span-5 clean-card rounded-2xl p-6 sticky top-6">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-[var(--border-color)]">
                <h3 id="formHeading" class="font-bold text-xs uppercase tracking-wider">Create New Task</h3>
                <button id="cancelEditBtn" onclick="resetForm()" class="hidden text-[10px] text-rose-600 font-semibold uppercase hover:underline">Cancel Edit</button>
            </div>
            <form id="taskForm" onsubmit="handleFormSubmit(event)" class="space-y-4">
                <input type="hidden" id="taskId">
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1 uppercase tracking-wider">Title *</label>
                    <input type="text" id="taskTitle" required placeholder="What needs to be done?" class="w-full clean-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1 uppercase tracking-wider">Description</label>
                    <textarea id="taskDesc" rows="3" placeholder="Add details..." class="w-full clean-input px-3.5 py-2.5 rounded-xl text-xs font-medium resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1 uppercase tracking-wider">Category</label>
                        <select id="taskCategory" class="w-full clean-input px-3 py-2 rounded-xl text-xs font-medium">
                            <option value="Work">Work</option>
                            <option value="Personal">Personal</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1 uppercase tracking-wider">Priority</label>
                        <select id="taskPriority" class="w-full clean-input px-3 py-2 rounded-xl text-xs font-medium">
                            <option value="Reminder">Reminder</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-[var(--text-secondary)] mb-1 uppercase tracking-wider">Deadline *</label>
                    <input type="date" id="taskDueDate" required class="w-full clean-input px-3 py-2 rounded-xl text-xs font-medium">
                </div>
                <button type="submit" id="submitBtn" class="w-full py-2.5 rounded-xl text-xs font-semibold uppercase primary-btn shadow-sm mt-2">Add Task</button>
            </form>
        </section>

        <!-- Column 2: Search, Filters & Task Feed (7 Columns) -->
        <section class="lg:col-span-7 space-y-4">
            
            <!-- Search & Filter Header Bar -->
            <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-[var(--text-secondary)]">
                        <i class="fa-solid fa-magnifying-glass text-[11px]"></i>
                    </span>
                    <input type="text" id="searchInput" oninput="handleSearch()" placeholder="Search tasks..." class="w-full clean-input pl-10 pr-4 py-2 rounded-xl text-xs font-medium">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                    <select id="categoryFilter" onchange="renderTasks()" class="clean-input px-3 py-2 rounded-xl text-xs font-medium w-full">
                        <option value="all">Categories</option>
                        <option value="Work">Work</option>
                        <option value="Personal">Personal</option>
                    </select>
                    <select id="priorityFilter" onchange="renderTasks()" class="clean-input px-3 py-2 rounded-xl text-xs font-medium w-full">
                        <option value="all">Priorities</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Reminder">Reminder</option>
                    </select>
                </div>
            </div>

            <!-- Task Grid List -->
            <div>
                <!-- Empty State -->
                <div id="emptyState" class="hidden py-16 text-center clean-card rounded-2xl">
                    <div class="w-10 h-10 mx-auto mb-3 rounded-xl border border-[var(--border-color)] bg-[var(--bg-primary)] flex items-center justify-center text-[var(--text-secondary)] text-xs">
                        <i class="fa-regular fa-clipboard"></i>
                    </div>
                    <h3 class="font-semibold text-xs uppercase tracking-wider">No tasks found</h3>
                    <p class="text-xs text-[var(--text-secondary)] font-medium mt-1">Use the left form to add your first task.</p>
                </div>

                <!-- Feed Grid -->
                <div id="taskGrid" class="space-y-3">
                    <!-- Injected dynamically -->
                </div>
            </div>

        </section>

    </main>

    <!-- Application Engine Script -->
    <script>
        let tasks = [];
        let currentFilter = 'all';
        let currentSearchQuery = '';

        window.onload = function() {
            document.getElementById('taskDueDate').min = new Date().toISOString().split('T')[0];
            renderApp();
        };

        function toggleDarkMode() {
            const body = document.getElementById('appBody');
            const icon = document.getElementById('themeIcon');
            if (body.classList.contains('dark')) {
                body.classList.remove('dark');
                icon.className = "fa-solid fa-moon";
            } else {
                body.classList.add('dark');
                icon.className = "fa-solid fa-sun";
            }
        }

        function setFilter(filter) {
            currentFilter = filter;
            ['all', 'pending', 'completed'].forEach(f => {
                const btn = document.getElementById(`tab-${f}`);
                if (f === filter) {
                    btn.className = "w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all bg-[var(--accent)] text-[var(--accent-text)] shadow-sm";
                } else {
                    btn.className = "w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-[var(--text-secondary)] hover:text-[var(--text-primary)] hover:bg-[var(--bg-primary)] transition-all";
                }
            });
            renderTasks();
        }

        function handleSearch() {
            currentSearchQuery = document.getElementById('searchInput').value.toLowerCase().trim();
            renderTasks();
        }

        function renderApp() {
            updateStats();
            renderTasks();
        }

        function updateStats() {
            const total = tasks.length;
            const pending = tasks.filter(t => t.status === 'pending').length;
            const completed = tasks.filter(t => t.status === 'completed').length;

            document.getElementById('statTotal').innerText = total;
            document.getElementById('statPending').innerText = pending;
            document.getElementById('statCompleted').innerText = completed;

            document.getElementById('badge-all').innerText = total;
            document.getElementById('badge-pending').innerText = pending;
            document.getElementById('badge-completed').innerText = completed;
        }

        function renderTasks() {
            const categoryVal = document.getElementById('categoryFilter').value;
            const priorityVal = document.getElementById('priorityFilter').value;

            const filtered = tasks.filter(t => {
                if (currentFilter !== 'all' && t.status !== currentFilter) return false;
                if (categoryVal !== 'all' && t.category !== categoryVal) return false;
                if (priorityVal !== 'all' && t.priority !== priorityVal) return false;
                if (currentSearchQuery && !t.title.toLowerCase().includes(currentSearchQuery) && !t.description.toLowerCase().includes(currentSearchQuery)) return false;
                return true;
            });

            const grid = document.getElementById('taskGrid');
            const emptyState = document.getElementById('emptyState');
            grid.innerHTML = '';

            if (filtered.length === 0) {
                emptyState.classList.remove('hidden');
                grid.classList.add('hidden');
                return;
            } else {
                emptyState.classList.add('hidden');
                grid.classList.remove('hidden');
            }

            filtered.forEach(task => {
                const isCompleted = task.status === 'completed';
                const card = document.createElement('div');
                card.className = "clean-card rounded-2xl p-4 flex flex-col justify-between";
                card.innerHTML = `
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase border border-[var(--border-color)] bg-[var(--bg-primary)] text-[var(--text-secondary)]">${task.category}</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase border ${task.priority === 'Urgent' ? 'border-rose-200 bg-rose-50 text-rose-600 dark:bg-rose-950/30 dark:text-rose-400' : 'border-amber-200 bg-amber-50 text-amber-600 dark:bg-amber-950/30 dark:text-amber-400'}">${task.priority}</span>
                            </div>
                            <span class="text-[10px] font-medium text-[var(--text-secondary)]"><i class="fa-regular fa-calendar mr-1"></i>${task.dueDate}</span>
                        </div>
                        <h4 class="font-semibold text-xs tracking-tight mb-1 ${isCompleted ? 'line-through opacity-50' : ''}">${escapeHtml(task.title)}</h4>
                        <p class="text-xs text-[var(--text-secondary)] font-normal line-clamp-2 leading-relaxed">${escapeHtml(task.description || 'No additional details provided.')}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-[var(--border-color)] flex items-center justify-between">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide ${isCompleted ? 'text-emerald-600 dark:text-emerald-400' : 'text-blue-600 dark:text-blue-400'}">
                            <span class="w-1.5 h-1.5 rounded-full ${isCompleted ? 'bg-emerald-600 dark:bg-emerald-400' : 'bg-blue-600 dark:bg-blue-400'}"></span>
                            ${isCompleted ? 'Completed' : 'In Progress'}
                        </span>
                        <div class="flex items-center gap-1">
                            <button onclick="toggleStatus('${task.id}')" title="${isCompleted ? 'Reopen' : 'Complete'}" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:border-[var(--border-hover)] transition-colors">
                                <i class="fa-solid ${isCompleted ? 'fa-rotate-left' : 'fa-check'} text-[11px]"></i>
                            </button>
                            <button onclick="loadIntoForm('${task.id}')" title="Edit" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:border-[var(--border-hover)] transition-colors">
                                <i class="fa-solid fa-pen text-[10px]"></i>
                            </button>
                            <button onclick="deleteTask('${task.id}')" title="Delete" class="w-7 h-7 rounded-lg clean-input flex items-center justify-center text-xs hover:text-rose-600 hover:border-rose-300 transition-colors">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
            updateStats();
        }

        function loadIntoForm(id) {
            const task = tasks.find(t => t.id === id);
            if (!task) return;
            document.getElementById('taskId').value = task.id;
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDesc').value = task.description;
            document.getElementById('taskCategory').value = task.category;
            document.getElementById('taskPriority').value = task.priority;
            document.getElementById('taskDueDate').value = task.dueDate;
            
            document.getElementById('formHeading').innerText = 'Edit Task';
            document.getElementById('submitBtn').innerText = 'Update Task';
            document.getElementById('cancelEditBtn').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('taskId').value = '';
            document.getElementById('taskForm').reset();
            document.getElementById('formHeading').innerText = 'Create New Task';
            document.getElementById('submitBtn').innerText = 'Add Task';
            document.getElementById('cancelEditBtn').classList.add('hidden');
        }

        function handleFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('taskId').value;
            const title = document.getElementById('taskTitle').value.trim();
            const description = document.getElementById('taskDesc').value.trim();
            const category = document.getElementById('taskCategory').value;
            const priority = document.getElementById('taskPriority').value;
            const dueDate = document.getElementById('taskDueDate').value;

            if (!title || !dueDate) return;

            if (id) {
                tasks = tasks.map(t => t.id === id ? { ...t, title, description, category, priority, dueDate } : t);
            } else {
                tasks.unshift({
                    id: Date.now().toString(),
                    title, description, category, priority, dueDate,
                    status: 'pending'
                });
            }
            resetForm();
            renderApp();
        }

        function toggleStatus(id) {
            tasks = tasks.map(t => t.id === id ? { ...t, status: t.status === 'completed' ? 'pending' : 'completed' } : t);
            renderApp();
        }

        function deleteTask(id) {
            tasks = tasks.filter(t => t.id !== id);
            renderApp();
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>