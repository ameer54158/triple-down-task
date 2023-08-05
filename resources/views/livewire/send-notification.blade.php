<div class="card">
    <div class="card-body">
        <form wire:submit.prevent="sendNotification({{$singleNotification->id}})">
            <div class="form-group mb-3">
                <h5 class="fw-bold">{{$singleNotification->title}}</h5>
                <h6 class="fw-bold">{{$singleNotification->description}}</h6>
            </div>
            <div class="form-group mb-3">
                <label for="description">Users: </label>
                @if(count($users))
                    @foreach($users as $user)
                        <label class="form-check" for="user_{{$user->id}}">
                            <input type="checkbox" wire:model="users_id" id="user_{{$user->id}}" value="{{$user->id}}" name="users_id[]">
                            {{$user->name}} ({{$user->email}})
                        </label>
                    @endforeach
                @endif
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-block">Send</button>
                <button wire:click.prevent="cancelNotification()" class="btn btn-secondary btn-block">Cancel</button>
            </div>
        </form>
    </div>

</div>
