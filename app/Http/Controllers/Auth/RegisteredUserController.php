<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostra la vista di registrazione.
     */
    public function create(): View
    {
        $types = Type::all();
        return view('auth.register', compact('types'));
    }

    /**
     * Gestisce una richiesta di registrazione in arrivo.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        // Validazione dei dati del modulo di registrazione
        $request->validate(
            $this->getValidations(),
            $this->getValidationMessages(),
        );


        $data = $request;
        if ($data['img']) {
            $img_path = Storage::put('uploads', $data['img']);
        } else {
            $img_path = null;
        }


        // Creazione di un nuovo utente
        $user = User::create([
            'restaurant_name' => $request->restaurant_name,
            'email' => $request->email,
            'address' => $request->address,
            'vat_number' => $request->vat_number,
            'img' => $img_path,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        $user->types()->attach($data['types']);

        // Generazione dell'evento di registrazione
        event(new Registered($user));

        // Login dell'utente appena registrato
        Auth::login($user);

        // Reindirizzamento alla pagina home
        return redirect(RouteServiceProvider::HOME);
    }

    // FUNZIONI DI VALIDAZIONE

    private function getValidations()
    {
        // Regole di validazione per i dati del modulo di registrazione
        return [
            'restaurant_name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['required', 'string', 'min:5', 'max:64'],
            'vat_number' => ['required', 'string', 'min:13', 'max:13', 'unique:' . User::class],
            'phone_number' => ['required', 'string', 'min:9', 'max:64'],
            'img' => ['image', 'mimes:jpeg,png,jpg'],
            'types' => ['required', 'array', 'min:1'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    private function getValidationMessages()
    {
        // Messaggi di errore personalizzati per le regole di validazione
        return [
            'restaurant_name.required' => 'Restaurant name must be at least 1 character.',
            'restaurant_name.min' => 'Restaurant name must be at least 1 character.',
            'restaurant_name.max' => 'Restaurant name cannot exceed 255 characters.',
            'email.email' => 'It must be a valid email address.',
            'email.unique' => 'This email address has already been registered.',
            'address.min' => 'The address must contain at least 5 characters.',
            'address.max' => 'The address cannot exceed 64 characters.',
            'vat_number.min' => 'VAT number must contain exactly 13 characters.',
            'vat_number.max' => 'VAT number must contain exactly 13 characters.',
            'vat_number.unique' => 'This VAT number has already been registered.',
            'phone_number.min' => 'Phone number must contain at least 9 characters.',
            'phone_number.max' => 'Phone number cannot exceed 64 characters.',
            'img.image' => 'The file must be a valid image.',
            'img.mimes' => 'The image file must be of type JPEG, PNG, or JPG.',
            'types.required' => 'At least one checkbox must be selected.',
            'types.min' => 'At least one checkbox must be selected.',
            'password.confirmed' => 'Password confirmation does not match.'
        ];
    }
}
