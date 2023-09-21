<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Account deleted.') }}
        </p>
    </header>

    <!-- Modal trigger button -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-account">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal Body -->

    <div class="modal fade" id="delete-account" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="delete-account" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-account">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want delete your Account?') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Save all your data.') }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')

                        <div class="input-group">

                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="{{ __('Password') }}" />

                            @error('password')
                                <span class="invalid-feedback mt-2" role="alert">
                                    <strong>{{ $errors->userDeletion->get('password') }}</strong>
                                </span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</section>
