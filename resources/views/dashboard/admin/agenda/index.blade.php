@extends('layouts.dashboard.app')

@section('title')
    My Gerindra | Agenda
@endsection

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables {{ $title }}</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">{{ $title }}</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Add {{ $title }}</h4>
                            <button type="button" class="btn btn-primary btn-round ms-auto" id="addAgendaButton"
                                data-bs-toggle="modal" data-bs-target="#addEventModal">
                                <i class="fa fa-plus"></i> {{ $title }}
                            </button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Menambahkan atau Mengedit Agenda -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addEventForm">
                @csrf
                <input type="hidden" id="eventId" name="id"> <!-- Input untuk menyimpan ID event -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">Tambah Agenda</h5> <!-- Judul modal dinamis -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Judul Agenda</label>
                            <input type="text" class="form-control" id="eventTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="eventStart" class="form-label">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventEnd" class="form-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" id="eventEnd" name="end">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Agenda</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.11/index.global.min.js'></script>

    <style>
        /* Ubah warna latar belakang event */
        .fc-event {
            background-color: #007bff;
            /* Ubah dengan warna lebih lembut */
            color: white;
            /* Warna teks event */
        }

        /* Ubah warna hover saat event di hover */
        .fc-event:hover {
            background-color: #0056b3;
            /* Warna lebih gelap saat hover */
        }

        /* Ubah warna grid kalender */
        .fc-daygrid-day {
            border: 1px solid #ddd;
            /* Border grid */
        }

        /* Ubah warna header (bulan/tanggal) */
        .fc-toolbar-title {
            color: #333;
            /* Warna teks judul kalender */
        }

        /* Ubah warna tombol navigasi (prev, next, today) */
        .fc-button {
            background-color: #6c757d;
            /* Warna tombol */
            color: white;
            border: none;
        }

        /* Ubah warna tombol saat dihover */
        .fc-button:hover {
            background-color: #5a6268;
            /* Warna lebih gelap saat hover */
        }

        /* Ubah warna hari yang dipilih */
        .fc-daygrid-day.fc-day-today {
            background-color: #ffc107;
            /* Warna untuk hari ini */
            color: white;
        }

        /* Ubah warna ketika seleksi hari di bulan */
        .fc-highlight {
            background-color: #e2e6ea;
            /* Warna seleksi */
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                events: '/getAgenda',
                editable: true,
                selectable: true,
                select: function(info) {
                    // Ketika menambah agenda baru
                    document.getElementById('addEventForm').reset();
                    document.getElementById('eventId').value = ''; // Kosongkan ID event
                    document.getElementById('addEventModalLabel').innerText =
                        'Tambah Agenda'; // Ubah judul modal
                    document.getElementById('eventStart').value = info.startStr + 'T00:00';
                    document.getElementById('eventEnd').value = info.endStr ? info.endStr.slice(0, 16) :
                        '';

                    let addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                    addEventModal.show();
                },
                eventClick: function(info) {
                    // Ketika mengedit agenda
                    document.getElementById('eventId').value = info.event.id; // Set ID event
                    document.getElementById('eventTitle').value = info.event.title;
                    document.getElementById('eventDescription').value = info.event.extendedProps
                        .description || '';
                    document.getElementById('eventStart').value = info.event.start.toISOString().slice(
                        0, 16);
                    document.getElementById('eventEnd').value = info.event.end ? info.event.end
                        .toISOString().slice(0, 16) : '';

                    document.getElementById('addEventModalLabel').innerText =
                        'Edit Agenda'; // Ubah judul modal
                    let editEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
                    editEventModal.show();
                },
                eventMouseEnter: function(info) {
                    let tooltip = document.createElement('div');
                    tooltip.setAttribute('class', 'tooltip-event');
                    tooltip.innerText = info.event.extendedProps.description || 'Tidak ada deskripsi';
                    document.body.appendChild(tooltip);

                    tooltip.style.position = 'absolute';
                    tooltip.style.top = info.jsEvent.pageY + 'px';
                    tooltip.style.left = info.jsEvent.pageX + 'px';
                    tooltip.style.backgroundColor = '#fff';
                    tooltip.style.border = '1px solid #ccc';
                    tooltip.style.padding = '5px';
                    tooltip.style.zIndex = '1000';

                    info.el.addEventListener('mouseleave', function() {
                        tooltip.remove();
                    });
                }
            });

            calendar.render();

            // Handle form submission (add/edit)
            document.getElementById('addEventForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let form = e.target;
                let formData = new FormData(form);
                let eventId = formData.get('id'); // Ambil ID event jika sedang mengedit
                let url = eventId ? `/agenda/${eventId}` :
                    '{{ route('agenda.store') }}'; // Tentukan URL berdasarkan add/edit
                let method = eventId ? 'PUT' : 'POST'; // Gunakan PUT untuk edit, POST untuk add

                fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            title: formData.get('title'),
                            description: formData.get('description'),
                            start: formData.get('start'),
                            end: formData.get('end')
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (eventId) {
                                // Update event di kalender jika sedang mengedit
                                let event = calendar.getEventById(eventId);
                                event.setProp('title', data.agenda.title);
                                event.setStart(data.agenda.start);
                                event.setEnd(data.agenda.end);
                                event.setExtendedProp('description', data.agenda.description);
                            } else {
                                // Tambahkan event baru ke kalender
                                calendar.addEvent({
                                    id: data.agenda.id,
                                    title: data.agenda.title,
                                    start: data.agenda.start,
                                    end: data.agenda.end,
                                    description: data.agenda.description
                                });
                            }
                            let addEventModal = bootstrap.Modal.getInstance(document.getElementById(
                                'addEventModal'));
                            addEventModal.hide();
                            alert('Agenda berhasil disimpan!');
                        } else {
                            alert('Terjadi kesalahan: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menyimpan agenda.');
                    });
            });
        });
    </script>
@endsection
