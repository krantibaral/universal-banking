<div class="form-group row">
    <!-- Name Field -->
    <div class="col-md-12">
        <label for="name">Name *</label>
        <input type="text" required class="form-control" id="name" name="name"
            value="{{ old('name', $item->user->name ?? '') }}" placeholder="Enter name">
    </div>
</div>

<div class="form-group row">
    <!-- Email Field -->
    <div class="col-md-12">
        <label for="email">Email *</label>
        <input type="email" required class="form-control" id="email" name="email"
            value="{{ old('email', $item->user->email ?? '') }}" placeholder="Enter email">
    </div>
</div>

<div class="form-group row">
    <!-- Password Field -->
    <div class="col-md-12">
        <label for="password">Password {{ isset($item) ? '' : '*' }}</label>
        <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>
</div>

<div class="form-group row">
    <!-- Verify Dropdown -->
    <div class="col-md-12">
        <label for="verified">Verified *</label>
        <select class="form-control" id="verified" name="verified" required>
            <option value="1" {{ old('verified', $item->verified ?? '') == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('verified', $item->verified ?? '') == 0 ? 'selected' : '' }}>No</option>
        </select>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');

        // Toggle password visibility
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
