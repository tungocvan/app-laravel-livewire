<div class="container py-4" x-data="{ showGallery: false }">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Add New Product</h4>
        </div>
        
        <div class="card-body">
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="name">Product Name <span class="text-danger">*</span></label>
                            <input type="text" wire:model.defer="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Product Description <span class="text-danger">*</span></label>
                            <textarea wire:model.defer="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required></textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="shortDescription">Short Description <span class="text-danger">*</span></label>
                            <textarea wire:model.defer="shortDescription" id="shortDescription" rows="3" class="form-control @error('shortDescription') is-invalid @enderror" required></textarea>
                            @error('shortDescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="categories">Categories <span class="text-danger">*</span></label>
                            <select wire:model.defer="categories" id="categories" class="form-control @error('categories') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($allCategories as $category)
                                    <option value="{{ $category->term_id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags</label>
                            <input type="text" wire:model.defer="tags" id="tags" class="form-control" placeholder="Separate with commas">
                            <small class="text-muted">Example: tag1, tag2, tag3</small>
                        </div>

                        <div class="form-group">
                            <label for="regularPrice">Regular Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" wire:model.defer="regularPrice" id="regularPrice" class="form-control @error('regularPrice') is-invalid @enderror" required>
                            @error('regularPrice') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="salePrice">Sale Price ($)</label>
                            <input type="number" step="0.01" wire:model.defer="salePrice" id="salePrice" class="form-control @error('salePrice') is-invalid @enderror">
                            @error('salePrice') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Main Image <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" wire:model="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" accept="image/*" required>
                                <label class="custom-file-label" for="image">
                                    @if($image)
                                        {{ $image->getClientOriginalName() }}
                                    @else
                                        Choose file
                                    @endif
                                </label>
                            </div>
                            @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                            @if($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" width="120">
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Gallery Images</label>
                            <button type="button" @click="showGallery = !showGallery" class="btn btn-sm btn-outline-secondary mb-2">
                                <span x-text="showGallery ? 'Hide Gallery' : 'Add Gallery Images'"></span>
                            </button>
                            
                            <div x-show="showGallery" x-transition class="border p-3 rounded">
                                <input type="file" wire:model="gallery" multiple class="form-control-file">
                                <small class="text-muted">You can select multiple images</small>
                                
                                @if($gallery)
                                    <div class="mt-2 d-flex flex-wrap">
                                        @foreach($gallery as $image)
                                            <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mr-2 mb-2" width="80">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right mt-4">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>Add Product</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        // Update custom file input label
        document.getElementById('image').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Choose file';
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    });
</script>
@endpush