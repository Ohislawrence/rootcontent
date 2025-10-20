@extends('layouts.app')

@section('title', 'Create New Plan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create New Subscription Plan
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('admin.plans.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Plan Name *</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., Basic Termly Plan">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700">Duration Type *</label>
                            <select name="duration" id="duration" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Duration Type</option>
                                <option value="termly" {{ old('duration') == 'termly' ? 'selected' : '' }}>Termly</option>
                                <option value="yearly" {{ old('duration') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="custom" {{ old('duration') == 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                            @error('duration')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="months" class="block text-sm font-medium text-gray-700">Duration (Months) *</label>
                            <input type="number" name="months" id="months" required value="{{ old('months') }}" min="1"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 3">
                            <p class="mt-1 text-sm text-gray-500">Number of months the subscription will last</p>
                            @error('months')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price (₦) *</label>
                            <input type="number" name="price" id="price" required value="{{ old('price') }}" min="0" step="0.01"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 5000.00">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Brief description of the plan...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                        <div id="features-container">
                            @if(old('features'))
                                @foreach(old('features') as $feature)
                                    <div class="feature-input flex mb-2">
                                        <input type="text" name="features[]" value="{{ $feature }}"
                                            class="flex-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Enter a feature">
                                        <button type="button" class="ml-2 remove-feature bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">
                                            Remove
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-feature" class="mt-2 bg-gray-500 hover:bg-gray-700 text-white px-3 py-2 rounded-md text-sm">
                            Add Feature
                        </button>
                        <p class="mt-1 text-sm text-gray-500">List the key features of this plan</p>
                        @error('features')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="is_active" class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-900">Active plan</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Inactive plans won't be available for new subscriptions</p>
                        </div>

                        <div>
                            <label for="is_default" class="flex items-center">
                                <input type="checkbox" name="is_default" id="is_default" value="1"
                                    {{ old('is_default') ? 'checked' : '' }}
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-900">Set as default plan</span>
                            </label>
                            <p class="mt-1 text-sm text-gray-500">Default plan will be highlighted for users</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.plans.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Create Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const featuresContainer = document.getElementById('features-container');
        const addFeatureButton = document.getElementById('add-feature');

        // Add feature input
        addFeatureButton.addEventListener('click', function() {
            const featureInput = document.createElement('div');
            featureInput.className = 'feature-input flex mb-2';
            featureInput.innerHTML = `
                <input type="text" name="features[]"
                    class="flex-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter a feature">
                <button type="button" class="ml-2 remove-feature bg-red-500 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">
                    Remove
                </button>
            `;
            featuresContainer.appendChild(featureInput);

            // Add remove functionality
            featureInput.querySelector('.remove-feature').addEventListener('click', function() {
                featuresContainer.removeChild(featureInput);
            });
        });

        // Add remove functionality to existing feature inputs
        document.querySelectorAll('.remove-feature').forEach(button => {
            button.addEventListener('click', function() {
                featuresContainer.removeChild(button.closest('.feature-input'));
            });
        });
    });
</script>
@endsection
