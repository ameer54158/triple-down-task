<div>
    <div class="col-md-8 mb-2 m-auto">
        <h5 class="fw-bold">Notifications</h5>

        <!-- Add flash message -->
        @include('common.flash-messages')

        @if($action == 'addNotification')
            @include('livewire.create-notification')
        @endif

        @if($action == 'editNotification')
            @include('livewire.update-notification')
        @endif

        @if($action == 'sentNotification')
            @include('livewire.send-notification')
        @endif

        @if($action == 'viewNotification')
            @include('livewire.notification-detail')
        @endif
    </div>
    <div class="col-md-8 m-auto">
        <div class="card">
            <div class="card-body">
                @if(Auth::user()->role == 'admin')
                    <button wire:click="addNotification()" class="btn btn-primary btn-sm">Add New
                        Notification
                    </button>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($notifications) > 0)
                            @foreach ($notifications as $notification)
                                <tr>
                                    <td>
                                        {{$notification->title}}
                                    </td>
                                    <td>
                                        {{Str::limit($notification->description,40)}}
                                    </td>
                                    <td>
                                        @if(Auth::user()->role == 'admin')
                                            <button wire:click="sendNotificationForm({{$notification->id}})"
                                                    class="btn btn-success btn-sm">Send
                                            </button>
                                            <button wire:click="notificationdetail({{$notification->id}})"
                                                    class="btn btn-secondary btn-sm">Detail
                                            </button>
                                            <button wire:click="editNotification({{$notification->id}})"
                                                    class="btn btn-primary btn-sm">Edit
                                            </button>
                                        @endif
                                        <button wire:click="deleteNotification({{$notification->id}})"
                                                class="btn btn-danger btn-sm">Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" align="center">
                                    No Notifications Found.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

