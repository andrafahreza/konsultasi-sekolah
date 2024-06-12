@extends('layouts.app')

@section('content')
    <div class="chat-wrapper d-lg-flex gap-1 p-1 mb-3">
        <div class="chat-wrapper-menu p-3 d-flex flex-column rounded">
            <ul class="chat-menu list-unstyled text-center nav nav-pills justify-content-center">
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover"
                    title="Chats">
                    <a href="#pills-chats" data-bs-toggle="pill" class="nav-link active"><i class="bi bi-chat-dots"></i></a>
                </li>

            </ul>
        </div>
        <div class="chat-leftsidebar">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-chats">
                    <div class="p-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="mb-4">Chats</h5>
                            </div>
                        </div>
                    </div> <!-- .p-4 -->

                    <div class="chat-room-list" data-simplebar>
                        <div class="chat-message-list">
                            <ul class="list-unstyled chat-list chat-user-list" id="userList"></ul>
                        </div>
                        <!-- End chat-message-list -->
                    </div>
                    <!-- end tab contact -->
                </div>
                <!-- end tab pane -->
            </div>
            <!-- end tab content -->
        </div>
        <!-- end chat leftsidebar -->

        <!-- Start User chat -->
        <div class="user-chat w-100 overflow-hidden">
            <div id="errorMessage" class="d-none">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>  Koneksi Error
                </div>
            </div>

            <div class="chat-content d-lg-flex">
                <!-- start chat conversation section -->
                <div class="w-100 overflow-hidden position-relative">
                    <!-- conversation user -->
                    <div class="position-relative">

                        <div class="position-relative" id="users-chat">
                            <div class="p-3 user-chat-topbar border-bottom border-2">
                                <div class="row align-items-center flex-nowrap">
                                    <div class="col-sm-4 col">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                <a href="javascript: void(0);" class="user-chat-remove fs-lg p-1"><i
                                                        class="ri-arrow-left-s-line align-bottom"></i></a>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                        <img src="@if ($photo == null) /user.png @else {{ $photo }} @endif"
                                                            class="rounded-circle avatar-xs" alt="">
                                                        <span class="user-status"></span>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="text-truncate mb-1 fs-lg"><a
                                                                class="text-reset username" data-bs-toggle="offcanvas"
                                                                href="#userProfileCanvasExample"
                                                                aria-controls="userProfileCanvasExample">{{ $nama }}</a>
                                                        </h5>
                                                        <p class="text-truncate text-muted fs-md mb-0 userStatus">
                                                            <small>Online</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end chat user head -->
                            <div class="chat-conversation p-3 p-lg-4" id="chat-conversation" data-simplebar>
                                <ul class="list-unstyled chat-conversation-list" id="users-conversation">
                                </ul>
                                <!-- end chat-conversation-list -->
                            </div>
                            <div class="alert alert-warning alert-dismissible copyclipboard-alert px-4 fade show "
                                id="copyClipBoard" role="alert">
                                Message copied
                            </div>
                        </div>

                        <!-- end chat-conversation -->

                        <div class="chat-input-section p-3 p-lg-4 border-top border-2">
                            <span class="text-warning">Sesi chat telah berakhir</span>
                        </div>

                        <div class="replyCard">
                            <div class="card mb-0">
                                <div class="card-body py-3">
                                    <div class="replymessage-block mb-0 d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="conversation-name"></h5>
                                            <p class="mb-0"></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" id="close_toggle"
                                                class="btn btn-sm btn-link mt-n2 me-n3 fs-lg">
                                                <i class="bx bx-x align-middle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/assets/libs/glightbox/js/glightbox.min.js"></script>
    <script src="/assets/libs/fg-emoji-picker/fgEmojiPicker.js"></script>
    <script src="/assets/js/pages/chat.init.js"></script>
    <script>
        setInterval(ajaxCall, 3000);

        function ajaxCall() {
            var url = "{{ route('get-chat') }}" + "/" + "{{ $chat->id }}";
            var photo = "{{ $photo }}";

            if (photo == null || photo == "") {
                photo = "/user.png";
            }

            console.log(photo);

            $('.nama_siswa').html("{{ $nama }}");
            $('.userprofile').attr('src', photo);

            $.ajax({
                type: "get",
                url: url,
                dataType: "JSON",
                success: function(response) {
                    console.log(response.data);
                    if (response.alert == '1') {
                        $('#users-conversation').html(response.data);
                        $('#errorMessage').addClass('d-none');
                    } else {
                        $('#errorMessage').removeClass('d-none');
                    }
                },
                error: function(response) {
                    $('#errorMessage').removeClass('d-none');
                }
            });
        }
    </script>
@endpush
