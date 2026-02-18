<style>.status-toggle-wrapper {
    position: relative;
    display: inline-block;
    width: 82px;          /* narrower */
    height: 26px;         /* shorter */
    cursor: pointer;
}

.status-toggle-input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
}

.status-toggle-slider {
    position: absolute;
    inset: 0;
    background-color: #dc3545; /* red OFF */
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.60rem;   /* smaller text */
    font-weight: 600;
    padding: 0 10px;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

/* Knob */
.status-toggle-slider::before {
    content: "";
    position: absolute;
    left: 2px;
    width: 22px;          /* smaller knob */
    height: 22px;
    border-radius: 50%;
    background-color: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.25);
    transition: transform 0.2s ease;
}

.status-toggle-text {
    position: relative;
    z-index: 1;
    line-height: 1;
}

/* ON state */
.status-toggle-input:checked + .status-toggle-slider {
    background-color: #198754; /* green ON */
}

/* 72 width - 22 knob - 2*2px margin ≈ 46 */
.status-toggle-input:checked + .status-toggle-slider::before {
    transform: translateX(56px);
}

/* Hover */
.status-toggle-wrapper:hover .status-toggle-slider {
    background-color: #dc3545; /* red OFF */
}
.status-toggle-wrapper:hover .status-toggle-slider::before {
    background-color: #fff;
}
.status-toggle-wrapper:hover .status-toggle-input:checked + .status-toggle-slider {
    background-color: #198754; /* green ON */
}</style>

@props([
    'id',
    'url',
    'checked' => false,
])

@php
    $isActive = (bool) $checked;
@endphp

<label class="status-toggle-wrapper mb-0">
    <input
        type="checkbox"
        class="status-toggle-input"
        data-id="{{ $id }}"
        data-url="{{ $url }}"
        {{ $isActive ? 'checked' : '' }}
    >
    <span class="status-toggle-slider">
        <span class="status-toggle-text">
            {{ $isActive ? 'Active' : 'Inactive' }}
        </span>
    </span>
</label>
