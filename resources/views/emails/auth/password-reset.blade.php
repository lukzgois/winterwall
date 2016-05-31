{!!
    trans('emails.forgot-password.body', [
        'user' => $user->name,
        'link' => url('/reset-password', ['token' => $token])
    ])
!!}