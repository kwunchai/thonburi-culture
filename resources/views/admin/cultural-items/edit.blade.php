@extends('layouts.admin')

@section('title', 'แก้ไขข้อมูลวัฒนธรรม')
@section('header', 'แก้ไขข้อมูลวัฒนธรรม')

@section('content')
<div class="card">
    <form action="{{ route('admin.cultural-items.update', $culturalItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>ชื่อ *</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $culturalItem->title) }}" required>
                @error('title')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>หมวดหมู่ *</label>
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">-- เลือก --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $culturalItem->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>ชุมชน *</label>
                        <select name="community_id" class="form-control @error('community_id') is-invalid @enderror" required>
                            <option value="">-- เลือก --</option>
                            @foreach($communities as $community)
                                <option value="{{ $community->id }}" 
                                    {{ old('community_id', $culturalItem->community_id) == $community->id ? 'selected' : '' }}>
                                    {{ $community->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('community_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>รายละเอียด *</label>
                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $culturalItem->description) }}</textarea>
                @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>รูปภาพ</label>
                        @if($culturalItem->image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($culturalItem->image) }}" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>วันที่เผยแพร่ *</label>
                        <input type="date" name="publish_date" class="form-control @error('publish_date') is-invalid @enderror" 
                               value="{{ old('publish_date', $culturalItem->publish_date->format('Y-m-d')) }}" required>
                        @error('publish_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" value="1" 
                           {{ old('is_published', $culturalItem->is_published) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_published">เผยแพร่ทันที</label>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="{{ route('admin.cultural-items.index') }}" class="btn btn-default">ยกเลิก</a>
        </div>
    </form>
</div>
@endsection