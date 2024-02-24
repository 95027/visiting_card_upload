<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-center">
                    <form action="{{ route('card.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="file" name="image" id="image" accept="image/*"
                                onchange="autoFillFields()"><br />
                            <label for="image">Upload an image for auto filling the form:</label><br />
                            @error('image')
                                <span style="color: red">{{ $message }}</span><br />
                            @enderror
                        </div>
                        <br />
                        <div>
                            <label for="name">Name:</label><br />
                            <input type="text" name="name" id="name">
                            @error('image')
                                <br />
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="email">Email:</label><br />
                            <input type="text" name="email" id="email">
                            @error('image')
                                <br />
                                <span style="color: red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone">Phone:</label><br />
                            <input type="number" name="phone" id="phone">
                            @error('image')
                                <br />
                                <span style="color: red">{{ $message }}</span><br />
                            @enderror
                        </div>
                        <br />
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function autoFillFields() {
            var input = document.getElementById('image');
            var file = input.files[0];
    
            if (file) {
                var formData = new FormData();
                formData.append('image', file);
    
                // Make an AJAX request to your server for OCR processing
                axios.post('/process-ocr', formData)
                    .then(function (response) {
                        
                        // Fill the form fields with the extracted data
                        document.getElementById('name').value = response.data.name;
                        document.getElementById('email').value = response.data.email;
                        document.getElementById('phone').value = response.data.phone;
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        }
    </script>


</x-app-layout>
