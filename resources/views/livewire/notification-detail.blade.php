<div class="card">
    <div class="card-body">
        <form wire:submit.prevent="sendNotification({{$singleNotification->id}})">
            <div class="form-group mb-3">
                <h5 class="fw-bold">{{$singleNotification->title}}</h5>
                <h6 class="fw-bold">{{$singleNotification->description}}</h6>
            </div>
            <div class="form-group mb-3">
                <label class="fw-bold">Users: </label>
                @if(count($singleNotification->users))
                    @foreach($singleNotification->users as $key=>$user)
                        <h6>{{++$key}}. {{$user->name}} ({{$user->email}})</h6>
                    @endforeach
                @else
                    <h6 class="text-secondary">This notification is not sent to any user yet.</h6>
                @endif
            </div>
            <div class="d-grid gap-2">
                <button wire:click.prevent="cancelNotification()" class="btn btn-secondary btn-block">Cancel</button>
            </div>
        </form>
    </div>

</div>
