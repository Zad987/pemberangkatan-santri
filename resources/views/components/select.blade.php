@props([
    'id' => null,
    'name' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'options' => [],
    'value' => null
])

<div class="form-group">
    @if($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <!-- Hidden input to store the selected value -->
    <input
        type="hidden"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
    />

    <!-- Custom dropdown -->
    <div class="custom-dropdown {{ $error ? 'is-invalid' : '' }} {{ $disabled ? 'disabled' : '' }}" data-dropdown-id="{{ $id }}">
        <div class="dropdown-trigger" tabindex="0">
            <span class="selected-text">
                @if($value && isset($options[$value]))
                    {{ $options[$value] }}
                @else
                    {{ $placeholder ?: 'Pilih opsi...' }}
                @endif
            </span>
            <span class="dropdown-arrow">▼</span>
        </div>
        <div class="dropdown-options">
            @if(!empty($options))
                @foreach($options as $key => $option)
                    <div class="dropdown-option {{ $value == $key ? 'selected' : '' }}" data-value="{{ $key }}">
                        {{ $option }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    @if($error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endif
</div>

<style>
.custom-dropdown {
    position: relative;
    width: 100%;
}

.dropdown-trigger {
    width: 100%;
    padding: 1rem 1.35rem;
    border-radius: var(--radius-lg);
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--primary), var(--primary-dark)) border-box;
    color: var(--text-main);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: var(--transition-base);
    outline: none;
    min-height: 48px;
    font-size: 1rem;
    font-family: var(--font-body);
    font-weight: 500;
}

.dropdown-trigger:focus {
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--primary), var(--primary-dark)) border-box;
    box-shadow: 0 0 0 4px var(--primary-light), var(--shadow-sm);
    transform: translateY(-1px);
}

.dropdown-trigger:hover:not(.disabled) {
    border: 2px solid transparent;
    background: linear-gradient(var(--bg-accent), var(--bg-accent)) padding-box,
                linear-gradient(135deg, var(--primary-light), var(--primary)) border-box;
    transform: translateY(-0.5px);
}

.custom-dropdown.open .dropdown-trigger {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom: 2px solid var(--primary);
}

.dropdown-arrow {
    transition: transform 0.3s ease;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.custom-dropdown.open .dropdown-arrow {
    transform: rotate(180deg);
}

.dropdown-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--bg-secondary);
    border: 2px solid var(--primary);
    border-top: none;
    border-radius: 0 0 var(--radius-lg) var(--radius-lg);
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    box-shadow: var(--shadow-lg);
}

.custom-dropdown.open .dropdown-options {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-option {
    padding: 0.75rem 1.35rem;
    cursor: pointer;
    transition: background 0.2s ease;
    border-bottom: 1px solid var(--border-light);
    outline: none;
}

.dropdown-option:last-child {
    border-bottom: none;
}

.dropdown-option:hover,
.dropdown-option:focus {
    background: var(--primary-light);
    color: var(--primary);
}

.dropdown-option.selected {
    background: var(--primary);
    color: white;
}

.custom-dropdown.disabled {
    opacity: 0.6;
    pointer-events: none;
}

.custom-dropdown.is-invalid .dropdown-trigger {
    border: 2px solid transparent !important;
    background: linear-gradient(var(--bg-secondary), var(--bg-secondary)) padding-box,
                linear-gradient(135deg, var(--danger), var(--danger-dark)) border-box !important;
}

.custom-dropdown.is-invalid .dropdown-trigger:focus {
    box-shadow: 0 0 0 4px var(--danger-light) !important;
}
</style>
