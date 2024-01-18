@extends('admin.layouts.app')
@section('title-admin', 'Create Room')
@section('css')
@endsection
@section('main-content')
    <div class="w-75 m-auto">
        <div>
            <a class="bg-green text-white fw-bold fs-5 rounded px-1" href="{{ route('admin.rooms.index') }}">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
        <form action="{{ route('admin.rooms.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Status</label>
                <div class="radio">
                    <label for="available">
                        <input type="radio" name="status" value="{{ STATUS_AVAILABLE }}" id="available"
                            {{ old('status') == STATUS_AVAILABLE ? 'checked' : '' }}>
                        Available
                    </label>
                    <label for="notAvailable">
                        <input type="radio" name="status" value="{{ STATUS_NOT_AVAILABLE }}" id="notAvailable"
                            {{ old('status') == STATUS_NOT_AVAILABLE ? 'checked' : '' }}>
                        Not available
                    </label>
                </div>
                @error('status')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Types Room</label>
                <select class="form-select" name="m_type_id">
                    <option value="">Choose...</option>
                    @foreach ($mTypes as $mType)
                        <option value={{ $mType->id }} {{ old('m_type_id') == $mType->id ? 'selected' : '' }}>
                            {{ $mType->name }}</option>
                    @endforeach
                </select>
                @error('m_type_id')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Price</label>
                <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="notice">{{ $message ?? '' }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="" class="form-label">Description</label>
                <textarea class="form-control" id="" rows="3" name="description">{!! old('description') !!}</textarea>
            </div>
            <div class="text-end">
                <input type="submit" class="bg-green text-white fw-bold fs-5 rounded p-1 text-end" value="Create">
            </div>
        </form>
    </div>
@endsection
@section('script')
@endsection
