<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CambiarPassword extends Component
{
    public $pass_actual,$pass_nueva,$pass_nueva2;
    public $mensaje;

    protected $rules = [
        'pass_actual' => 'required',
        'pass_nueva' => 'required',
        'pass_nueva2' => 'required|same:pass_nueva',
    ];
    public $rules2 = [
        'pass_actual' => 'required',
    ];

    protected $validationAttributes = [
        'pass_actual' => 'Contraseña',
        'pass_nueva' => 'Contraseña Nueva',
        'pass_nueva2' => 'Confirmar Contraseña',
    ];
    public function cambiar()
    {
        $this->validate($this->rules2);
        if (Hash::check($this->pass_actual,auth()->user()->password)) {
        $this->validate();
        $usuario = User::find(auth()->user()->id);
        $usuario->password = bcrypt($this->pass_nueva);
        $usuario->save();
        $this->mensaje = "se reinicio la contraseña";
        }
        else
        {
            $this->mensaje = "la contraseña actual no es la correcta";
        }
    }

    #####################################################
    public function render()
    {
        return view('livewire.cambiar-password');
    }
}
