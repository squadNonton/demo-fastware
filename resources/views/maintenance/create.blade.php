@extends('layout')

@section('content')

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-mt-4">
                <div class="card">
                    <div class="accordion">
                        <div class="card-body">
                            <h5 class="card-title">Form Permintaan Perbaikan</h5>
                            <div class="collapse" id="updateProgress">

                                <form id="FPPForm" action="{{ route('formperbaikans.update', $formperbaikan->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="pemohon" class="form-label">
                                            Pemohon<span style="color: red;">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="pemohon" name="pemohon" value="{{ $formperbaikan->pemohon }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mesin" class="form-label">
                                            Mesin<span style="color: red;">*</span>
                                        </label>
                                        <select class="form-select" id="mesin" name="mesin" disabled>
                                            <option value="{{ $formperbaikan->mesin }}" selected>{{ $formperbaikan->mesin }}</option>
                                        </select>
                                        <input type="hidden" name="mesin" value="{{ $formperbaikan->mesin }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="section" class="form-label">
                                            Section<span style="color: red;">*</span>
                                        </label>
                                        <select class="form-select" id="section" name="section" disabled>
                                            <option value="{{ $formperbaikan->section }}" selected>{{ $formperbaikan->section }}</option>
                                        </select>
                                        <input type="hidden" name="section" value="{{ $formperbaikan->section }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="kendala" class="form-label">
                                            Kendala<span style="color: red;">*</span>
                                        </label>
                                        <textarea class="form-control" id="kendala" name="kendala" readonly>{{ $formperbaikan->kendala }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <div id="gambarPreviewContainer">
                                            @if($formperbaikan->gambar)
                                            <img id="gambarPreview" src="{{ asset($formperbaikan->gambar) }}" alt="Preview Gambar" style="max-width: 200px; cursor: pointer;">
                                            @else
                                            <p>No image available</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div id="imageModal" class="modal">
                                        <span class="close" onclick="closeImageModal()">&times;</span>
                                        <img class="modal-content" id="img01">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-mt-4">
                <div class="card">
                    <div class="accordion">
                        <div class="card-body">
                            <h5 class="card-title">Update Progres</h5>

                            <div class="collapse" id="updateProgress">
                                <!-- Form Update Progress -->
                                <form id="updateForm" action="{{ route('formperbaikans.update', $formperbaikan->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!-- Tindak Lanjut -->
                                    <div class="mb-3">
                                        <label for="tindak_lanjut" class="form-label">Tindak Lanjut</label>
                                        <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="3"></textarea>
                                    </div>

                                    <!-- Due Date -->
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date">
                                    </div>

                                    <!-- Schedule Pengecekan -->
                                    <div class="mb-3">
                                        <label for="schedule_pengecekan" class="form-label">Schedule Pengecekan</label>
                                        <input type="date" class="form-control" id="schedule_pengecekan" name="schedule_pengecekan">
                                    </div>

                                    <!-- Input for attachment file -->
                                    <div class="mb-3">
                                        <label for="attachment_file" class="form-label">Attachment File</label>
                                        <!-- Input file for existing attachment -->
                                        <input type="file" class="form-control" id="attachment_file" name="attachment_file">
                                        <br>
                                        <br>
                                    </div>
                                    <!-- Hidden Inputs for Confirmation -->
                                    <input type="hidden" name="confirmed_finish" id="confirmed_finish" value='0'>
                                    <input type="hidden" name="confirmed_finish6" id="confirmed_finish6" value='0'>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary" id="saveButton" onclick="handleSaveButtonClick()">Save</button>
                                        <button type="button" class="btn btn-primary" id="finishButton" onclick="handleFinishButtonClick()">Finish</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="accordion">
                            <h5 class="card-title">Tabel Riwayat Progres</h5>
                            <div class="collapse" id="updateProgress">
                                <!-- Tabel History Progress -->
                                <div class="table-responsive">
                                    <table id="" class="display" style="table-layout: fixed;">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Tindak Lanjut</th>
                                                <th scope="col">Schedule Pengecekan</th>
                                                <th scope="col">PIC</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Note</th>
                                                <th scope="col">Last Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($formperbaikan->tindaklanjuts as $tindaklanjut)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $tindaklanjut->tindak_lanjut }}</td>
                                                <td>{{ $tindaklanjut->schedule_pengecekan }}</td>
                                                <td>{{ $tindaklanjut->pic }}</td>
                                                <td>{{ $tindaklanjut->due_date }}</td>
                                                <td>
                                                    @if ($tindaklanjut->attachment_file)
                                                    @php
                                                    $fileName = basename($tindaklanjut->attachment_file);
                                                    $buttonClass = $tindaklanjut->getAttachmentButtonClass();
                                                    $buttonIcon = $tindaklanjut->getAttachmentButtonIcon();
                                                    @endphp
                                                    <a href="{{ route('download.attachment', $tindaklanjut) }}" target="_blank" class="{{ $buttonClass }}">
                                                        <i class="{{ $buttonIcon }}"></i> {{ $fileName }}
                                                    </a>
                                                    @else
                                                    <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div style="background-color: {{ $tindaklanjut->status_background_color }};
                                            border-radius: 5px; /* Rounded corners */
                                            padding: 5px 10px; /* Padding inside the div */
                                            color: white; /* Text color, adjust as needed */
                                            font-weight: bold; /* Bold text */
                                            text-align: center; /* Center-align text */
                                            text-transform: uppercase; /* Uppercase text */
                                            ">
                                                        {{ $tindaklanjut->ubahtext() }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="background-color: {{ $tindaklanjut->note_background_color }};
                        border-radius: 5px; /* Rounded corners */
                        padding: 5px 10px; /* Padding inside the div */
                        color: black; /* Text color, adjust as needed */
                        font-weight: bold; /* Bold text */
                        text-align: center; /* Center-align text */
                        text-transform: uppercase; /* Uppercase text */
                        ">
                                                        {{ $tindaklanjut->note }}
                                                    </div>
                                                </td>
                                                <td>{{ $tindaklanjut->updated_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
    </section>

</main>
@endsection

<!-- Letakkan skrip JavaScript ini di dalam tag <head> atau sebelum tag </body> -->
<script>
    function handleSaveButtonClick() {
        // Validate schedule_pengecekan against due_date
        var schedulePengecekan = document.getElementById('schedule_pengecekan').value;
        var dueDate = document.getElementById('due_date').value;

        if (schedulePengecekan && dueDate && schedulePengecekan > dueDate) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Schedule Pengecekan tidak boleh melebihi Due Date.'
            });
            return;
        }

        // If validation passes, proceed with form submission
        document.getElementById('confirmed_finish6').value = '1';
        document.getElementById('updateForm').submit();
    }
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var gambarPreview = document.getElementById('gambarPreview');
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("img01");

        function toggleImageModal() {
            if (modal.style.display === "block") {
                closeImageModal();
            } else {
                modal.style.display = "block";
                modalImg.src = gambarPreview.src;
            }
        }

        function closeImageModal() {
            modal.style.display = "none";
        }

        // Menambahkan event listener untuk menutup modal saat tombol "X" diklik
        var closeButton = document.querySelector(".close");
        closeButton.addEventListener('click', function() {
            closeImageModal();
        });

        // Menambahkan event listener untuk menutup modal saat gambar pratinjau diklik kembali
        gambarPreview.addEventListener('click', function() {
            toggleImageModal();
        });

        // Menambahkan event listener untuk menutup modal saat area di luar modal diklik
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                closeImageModal();
            }
        });
    });
</script>

<style>
    /* CSS untuk modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        align-items: center;
        /* Mengatur penempatan vertikal ke tengah */
        justify-content: center;
        /* Mengatur penempatan horizontal ke tengah */
    }

    /* Konten dalam modal */
    .modal-content {
        max-width: 80%;
        max-height: 80%;
        background-color: white;
        padding: 20px;
        border-radius: 4px;
        position: relative;
    }

    /* Tombol close */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

    /* CSS untuk gambar di dalam modal */
    .modal-content img {
        width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var attachmentInput = document.getElementById('attachment_file');
        var filePreview = document.getElementById('filePreview');

        // Check if there's an existing file and trigger previewFile
        if (attachmentInput.files.length > 0) {
            previewFile(attachmentInput, filePreview);
        }

        attachmentInput.addEventListener('change', function() {
            previewFile(this, filePreview);
        });

        function previewFile(input, previewElement) {
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                if (file.type.includes('image')) {
                    previewElement.src = e.target.result;
                } else if (file.name.toLowerCase().endsWith('.xlsx') || file.name.toLowerCase().endsWith('.xls')) {
                    // For Excel files, provide a link for downloading
                    var excelLink = document.createElement('a');
                    excelLink.href = e.target.result;
                    excelLink.textContent = 'Download Excel File';
                    excelLink.setAttribute('target', '_blank');
                    previewElement.innerHTML = '';
                    previewElement.appendChild(excelLink);
                } else {
                    // For other file types, display a message
                    previewElement.textContent = 'Preview not available for this file type.';
                }
            };

            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>

<script>
    function handleFinishButtonClick() {
        // Validate schedule_pengecekan against due_date
        var schedulePengecekan = document.getElementById('schedule_pengecekan').value;
        var dueDate = document.getElementById('due_date').value;

        if (schedulePengecekan && dueDate && schedulePengecekan > dueDate) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Schedule Pengecekan tidak boleh melebihi Due Date.'
            });
            return;
        }

        // Show SweetAlert confirmation
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin mengubah status menjadi Finish?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                // Set the value of confirmed_finish to 1 before submitting the form
                document.getElementById('confirmed_finish').value = '1';

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Status berhasil diubah menjadi Finish!',
                    showConfirmButton: false,
                    timer: 2000, // Durasi notifikasi dalam milidetik
                    didClose: () => {
                        // Submit the form after the success notification is closed
                        document.getElementById('updateForm').submit();
                    }
                });
            }
        });
    }
</script>
