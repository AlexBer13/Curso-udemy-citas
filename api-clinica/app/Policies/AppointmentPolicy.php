<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appointment\Appointment;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->can('list_apppointment')){
            return true;
        }
        return false;
    }

    public function filter(User $user): bool
    {
        if($user->can('register_apppointment') || $user->can('edit_apppointment')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appointment $appointment): bool
    {

        if($user->can('edit_apppointment') || $user->can('add_payment')){
            if(str_contains(Str::upper($user->roles->first()->name),'DOCTOR') && !$user->can('add_payment')){
                //DOCTOR
                if($user->id == $appointment->doctor_id){
                    return true;
                }
            }else{
                //USUARIO REGISTRADO A LA CITA MEDICA
                if($user->id == $appointment->user_id){
                    return true;
                }
            }
        }
        return false;
    }
    

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->can('register_apppointment')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appointment $appointment): bool
    {
        if($user->can('edit_apppointment')){
            if(str_contains(Str::upper($user->roles->first()->name),'DOCTOR')){
                //DOCTOR
                if($user->id == $appointment->doctor_id){
                    return true;
                }
            }else{
                //USUARIO REGISTRADO A LA CITA MEDICA
                if($user->id == $appointment->user_id){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        if($user->can('delete_apppointment')){
            return true;
        }
        if(str_contains(Str::upper($user->roles->first()->name),'DOCTOR')){
            //DOCTOR
            if($user->id == $appointment->doctor_id){
                return true;
            }
        }else{
            //USUARIO REGISTRADO A LA CITA MEDICA
            if($user->id == $appointment->user_id){
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        //
    }
}
