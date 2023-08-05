<?php

namespace App\Http\Livewire;

use App\Jobs\SendUserNotifications;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Notification as Notifications;

class Notification extends Component
{
    public  $title, $description, $action='', $users = array(),$users_id=[],$singleNotification='';

    /**
     * delete action listener
     */

    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'title' => 'required',
        'description' => 'required'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields()
    {
        $this->resetValidation();
        $this->title = '';
        $this->description = '';
        $this->action = '';
        $this->users_id = [];
    }

    /**
     * render the post data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        if(Auth::user()->role == 'admin'){
            $this->notifications = Notifications::orderby('id','ASC')->get();
        }else{
            $this->notifications = Auth::user()->notifications()->orderby('id','ASC')->get();
        }
        return view('livewire.notification');
    }

    /**
     * Open Add Notification form
     * @return void
     */
    public function addNotification()
    {
        $this->resetFields();
        $this->action = 'addNotification';
    }

    /**
     * store the user inputted post data in the livewire table
     * @return void
     */
    public function storeNotification()
    {
        $this->validate();
        try {
            Notifications::create([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success', 'Notification Created Successfully!!');
            $this->resetFields();
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    /**
     * show existing notification data in edit notification form
     * @param mixed $id
     * @return void
     */
    public function editNotification($id)
    {
        try {
            $notification = Notifications::findOrFail($id);
            if (!$notification) {
                session()->flash('error', 'Notification not found');
            } else {
                $this->singleNotification = $notification;
                $this->title = $notification->title;
                $this->description = $notification->description;
                $this->notificationId = $notification->id;
                $this->action = 'editNotification';
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }

    }

    /**
     * update the notification data
     * @return void
     */
    public function updateNotification()
    {
        $this->validate();
        try {
            Notifications::whereId($this->notificationId)->update([
                'title' => $this->title,
                'description' => $this->description
            ]);
            session()->flash('success', 'Notification Updated Successfully!!');
            $this->resetFields();
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    /**
     * Cancel Add/Edit form and redirect to notification listing page
     * @return void
     */
    public function cancelNotification()
    {
        $this->resetFields();
    }

    /**
     * delete specific notification data from the livewire table
     * @param mixed $id
     * @return void
     */
    public function deleteNotification($id)
    {
        try {
            if(Auth::user()->role == 'admin'){
                Notifications::find($id)->delete();
            }else{
                UserNotification::where('user_id',Auth::user()->id)->where('notification_id',$id)->delete();
            }
            session()->flash('success', "Notification Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
        }
    }

    //Show send notification form
    public function sendNotificationForm($id){

        try {
            $this->singleNotification = Notifications::findOrFail($id);
            if (!$this->singleNotification) {
                session()->flash('error', 'Notification not found');
            } else {
                $this->action = 'sentNotification';
                $this->users = User::orderBy('name','ASC')->get();
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    //Send notification
    public function sendNotification($id){
        try {
            if(!count($this->users_id)){
                session()->flash('error', 'Please select some users');
                return;
            }
            $notification = Notifications::findOrFail($id);
            if ($notification) {
                SendUserNotifications::dispatch($notification->id,$this->users_id);
                $this->resetFields();
                session()->flash('success', 'Notification has been sent.');
            } else {
                session()->flash('error', 'Notification not found');
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    //Notification detail
    public function notificationdetail($id){

        try {
            $this->singleNotification = Notifications::findOrFail($id);
            if (!$this->singleNotification) {
                session()->flash('error', 'Notification not found');
            } else {
                $this->action = 'viewNotification';
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }
}
