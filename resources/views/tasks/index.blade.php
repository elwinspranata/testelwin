<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMaster | Premium Task Management</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #f8fafc;
            --card-border: rgba(226, 232, 240, 0.8);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
            line-height: 1.6;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--card-border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card {
            border: 1px solid var(--card-border);
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: var(--transition);
            background: #ffffff;
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--card-border);
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.6rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f1f5f9;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            padding: 1rem 1.5rem;
            border: none;
        }

        .table td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge-status {
            padding: 0.4em 0.8em;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: capitalize;
        }

        .status-pending { background: #fee2e2; color: #991b1b; }
        .status-in_progress { background: #fef9c3; color: #854d0e; }
        .status-completed { background: #dcfce7; color: #166534; }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            transition: var(--transition);
        }

        .btn-icon:hover {
            transform: scale(1.1);
        }

        .modal-content {
            border: none;
            border-radius: 1.25rem;
        }

        /* Micro-animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body>

<nav class="navbar mb-5">
    <div class="container text-center">
        <a class="navbar-brand mx-auto" href="#">
            <i data-lucide="layout-grid"></i>
            TaskMaster
        </a>
    </div>
</nav>

<div class="container animate-fade-in">

    <div class="row mb-4 align-items-center">
        <div class="col-6">
            <h3 class="fw-bold m-0">Dashboard Task</h3>
            <p class="text-muted small">Kelola dan pantau produktivitas tim Anda.</p>
        </div>
        <div class="col-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i data-lucide="plus" class="me-2" style="width: 18px"></i> Tambah Task
            </button>
        </div>
    </div>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul Task</th>
                            <th>Pemilik</th>
                            <th>Status</th>
                            <th>Waktu Mulai</th>
                            <th>Durasi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">{{ $task->title }}</div>
                                <small class="text-muted">ID: {{ substr($task->id, 0, 8) }}...</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size: 0.8rem">
                                        {{ strtoupper(substr($task->owner->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span>{{ $task->owner->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-status status-{{ $task->status }}">
                                    {{ str_replace('_', ' ', $task->status) }}
                                </span>
                            </td>
                            <td>
                                @if($task->start_time)
                                    <span class="small">{{ \Carbon\Carbon::parse($task->start_time)->format('d M, H:i') }}</span>
                                @else
                                    <span class="text-muted small italic">Belum dimulai</span>
                                @endif
                            </td>
                            <td>
                                @if($task->duration_minutes)
                                    <span class="badge bg-light text-dark border">{{ $task->duration_minutes }} menit</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if(!$task->start_time)
                                        <a href="/task/start/{{ $task->id }}" class="btn btn-icon btn-outline-warning" title="Mulai Task">
                                            <i data-lucide="play" style="width: 16px"></i>
                                        </a>
                                    @endif

                                    @if($task->start_time && !$task->end_time)
                                        <a href="/task/end/{{ $task->id }}" class="btn btn-icon btn-outline-success" title="Selesaikan Task">
                                            <i data-lucide="check-circle" style="width: 16px"></i>
                                        </a>
                                    @endif

                                    <button onclick="editTask('{{ $task->id }}')" class="btn btn-icon btn-outline-primary" title="Edit Task">
                                        <i data-lucide="edit-3" style="width: 16px"></i>
                                    </button>

                                    <button onclick="confirmDelete('{{ $task->id }}')" class="btn btn-icon btn-outline-danger" title="Hapus Task">
                                        <i data-lucide="trash-2" style="width: 16px"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i data-lucide="inbox" class="mb-3 text-muted" style="width: 48px; height: 48px"></i>
                                <p class="text-muted">Belum ada task yang dibuat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Task Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/task/store" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Task</label>
                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul task..." required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Penanggung Jawab</label>
                        <select name="owner_id" class="form-select" required>
                            <option value="">Pilih User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTaskForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Judul Task</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Penanggung Jawab</label>
                        <select name="owner_id" id="edit_owner_id" class="form-select" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    lucide.createIcons();

    function editTask(id) {
        fetch(`/task/edit/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_title').value = data.title;
                document.getElementById('edit_owner_id').value = data.owner_id;
                document.getElementById('editTaskForm').action = `/task/update/${id}`;
                new bootstrap.Modal(document.getElementById('editTaskModal')).show();
            });
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data task ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4f46e5',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/task/delete/${id}`;
            }
        });
    }
</script>

</body>
</html>
