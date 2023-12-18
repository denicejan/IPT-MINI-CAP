@extends('base')

@section('content')
<div class="text-white">
    <header class="p-4" style="
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        background-color: rgb(255, 238, 231);
        z-index: 1;
        position: fixed;
        width: 100%;
">
        <div class="d-flex justify-content-between">
            <div class="">
                <h1 class="p-3" style="
                    box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
                    border-radius: 50px; background-color: rgb(79, 54, 7)"><i class="fa-solid fa-jar"></i> ApaBagoong Online Store</h1>
            </div>
            <div class="p-3" style="
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            font-size: 30px; border-radius: 50px; background-color: rgb(79, 54, 7)">
                <a class="btn text-white" href="/dashboard"><i class="fa-solid fa-jar"></i> Item</a>
                @role('user')
                <a class="btn text-white" href="/aboutUs"><i class="fa-solid fa-jar"></i> About Us</a>
                @endrole


                @role('admin')
                <a class="btn text-white" href="/logs"><i class="fa-solid fa-clock-rotate-left"></i> History</a>
                @endrole

                <button class="text-white rounded-lg pe-4 ps-4 text-danger btn" style="background-color: transparent; font-size: 20px;" id="logoutButton" data-toggle="modal" data-target="#confirmLogoutModal"><i class="fa-solid fa-right-from-bracket"></i> {{ Auth::user()->name }}</button>
            </div>
        </div>
    </header>

    <div>
        <div class="p-5">
            <div style="margin-top: 100px;">
                <h1 class="d-flex text-white float-right" style="margin-top: 20px;">
                    {{-- <span class="p-3 rounded-lg" style="background-color: rgb(79, 54, 7);">Available Item</span> --}}
                    @role('admin')
                    <button style="font-size: 20px;" type="button" class="btn text-white" data-toggle="modal" data-target="#exampleModal">
                        <span class="p-2 rounded-lg" style="
                            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
                            background-color: rgb(79, 54, 7);"><i class="fa fa-plus"></i> Add Item</span>
                    </button>
                    @endrole
                </h1> <br> <br>
                <br>

                <div style="place-content: center;" class="d-flex flex-wrap">
                    @foreach ($bagoongs as $bagoong)
                        <div class="m-5">

                            <div class="bg-secondary">
                                <div class="m-5">
                                    <div class="order-card" id="orderCard_{{ $bagoong->id }}" style="border-radius: 50px; text-align: center; width: 500px; color: black; display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); z-index: 1000;">
                                        <h3>Ordering Please Wait!</h3>
                                        <h5><span class="text-success"><i class="fa fa-check"></i></span> Check your email soon</h5>
                                    </div>

                                    <form id="orderForm_{{ $bagoong->id }}" action="{{ route('bagoong.download', $bagoong) }}" method="POST">
                                        @csrf
                                        <div class="view-button">
                                            @role('user')
                                                <button style="text-shadow: 0 0 10px white;" class="btn text-primary orderBtn" data-bagoong-id="{{ $bagoong->id }}" onclick="submitOrderForm(this)"><i class="fa fa-edit"></i> Order Now</button>
                                            @endrole
                                            <div class="d-flex" style="place-content: center;">
                                                @role('admin')
                                                <button type="button" style="" class="btn text-success orderBtn" data-toggle="modal" data-target="#editModal-{{ $bagoong->id }}"><i class="fa fa-edit"></i> Edit</button>
                                                <button type="button" style="" class="btn text-danger orderBtn" data-toggle="modal" data-target="#deleteModal-{{ $bagoong->id }}" data-bagoong-id="{{ $bagoong->id }}"><i class="fa fa-trash"></i> Delete</button>
                                                @endrole
                                            </div>
                                        </div>
                                    </form>

                                    <img class="mb-5" width="300px;" src="https://gringo.ph/cdn/shop/products/BagoongSweetspicy_1024x1024.png?v=1606203989" alt="">
                                    <div class="p-2">
                                        <h5>Name: {{$bagoong->name}}</h5>
                                        <hr>
                                        <h5>Description: {{$bagoong->description}}</h5>
                                        <hr>
                                        <h5>Price: {{$bagoong->price}}</h5>
                                        <hr>
                                        <h5>Flavor: {{$bagoong->flavor}}</h5>
                                        <hr>
                                        <h5>Size: {{$bagoong->size}}</h5>
                                        <hr>
                                    </div>
                                </div>

                            </div>

                        </div>
                          <!-- Edit Modal -->
                          <div id="editModal-{{ $bagoong->id }}" class="modal fade" style="margin-top: 100px" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog text-white" role="document">
                                <div class="modal-content" style="background-color: rgb(72, 19, 9)">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm-{{ $bagoong->id }}" method="POST" action="{{ route('bagoongs.update', $bagoong) }}">
                                            @csrf
                                            @method('PATCH')

                                            <!-- Add form fields for editing the bagoong's data here -->
                                            <div class="form-group">
                                                <label for="name">Name:</label>
                                                <input type="text" class="form-control bg-transparent text-white" id="name" name="name" value="{{ $bagoong->name }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Description:</label>
                                                <textarea class="form-control bg-transparent text-white" id="description" name="description" rows="5">{{ $bagoong->description }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="price">Price:</label>
                                                <input type="text" class="form-control bg-transparent text-white" id="price" name="price" value="{{ $bagoong->price }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="flavor">Flavor:</label>
                                                <select name="flavor" id="flavor" class="form-control bg-transparent text-white" required>
                                                    @foreach(['Bagoong Alamang (Shrimp Paste)', 'Bagoong Isda (Fish Paste)', 'BAGOONG MONAMON', 'BAGOONG TERONG', 'GINAMOS', 'TINABAL', 'BAGOONG PADAS'] as $option)
                                                        <option class="text-dark" value="{{ $option }}" {{ $option === $bagoong->flavor ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="size">Size:</label>
                                                <select name="size" id="size" class="form-control bg-transparent text-white" required>
                                                    @foreach(['Large', 'Medium', 'Small'] as $option)
                                                        <option class="text-dark" value="{{ $option }}" {{ $option === $bagoong->size ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-cancel"></i> Cancel</button>
                                        <button type="submit" form="editForm-{{ $bagoong->id }}" class="btn btn-secondary text-white"><i class="fa fa-save"></i> Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- Delete Modal -->
                        <div id="deleteModal-{{ $bagoong->id }}" class="modal fade" style="margin-top: 300px" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog text-white" role="document">
                                <div class="modal-content" style="background-color: rgb(72, 19, 9)">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this Item?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <form id="deleteForm-{{ $bagoong->id }}" method="POST" action="{{ route('bagoongs.destroy', $bagoong) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>



</div>

<!-- Confirm Logout -->
<div class="modal fade" style="margin-top: 300px" id="confirmLogoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog text-white" role="document">
      <div class="modal-content" style="background-color: rgb(72, 19, 9)">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirm Logout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to logout?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Confirm Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div  class="modal fade" style="margin-top: 100px" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="modal-content text-white" style="background-color: rgb(72, 19, 9)">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><b>Create Item</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <form method="POST" action="{{ route('bagoongs.store') }}">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control bg-transparent text-white" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control bg-transparent text-white" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" id="price" class="form-control bg-transparent text-white" required>
                    </div>

                    <div class="form-group">
                        <label for="flavor">Flavor:</label>
                        <select name="flavor" id="flavor" class="form-control bg-transparent text-white" required>
                            <option class="text-dark" value="Bagoong Alamang (Shrimp Paste)">Bagoong Alamang (Shrimp Paste)</option>
                            <option class="text-dark" value="Bagoong Isda (Fish Paste)">Bagoong Isda (Fish Paste)</option>
                            <option class="text-dark" value="BAGOONG MONAMON">BAGOONG MONAMON</option>
                            <option class="text-dark" value="BAGOONG TERONG">BAGOONG TERONG</option>
                            <option class="text-dark" value="GINAMOS">GINAMOS</option>
                            <option class="text-dark" value="TINABAL">TINABAL</option>
                            <option class="text-dark" value="BAGOONG PADAS">BAGOONG PADAS</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="size">Size:</label>
                        <select name="size" id="size" class="form-control bg-transparent text-white" required>
                            <option class="text-dark" value="Large">Large</option>
                            <option class="text-dark" value="Medium">Medium</option>
                            <option class="text-dark" value="Small">Small</option>
                        </select>
                    </div>


                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-secondary">Save changes</button>

            </div>
        </div>
        </div>
    </form>
</div>

<style>
    .orderBtn{
        font-size: 20px;
        transition: 0.5s
    }
    .orderBtn:hover{
        font-size: 30px;
    }
     @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-20px);
        }
        60% {
            transform: translateY(-10px);
        }
    }

    .order-card h3 {
        animation: bounce 2s infinite; /* Adjust the animation duration as needed */
    }

     @keyframes fadeInFromLeft {
        from {
            opacity: 0;

        }
        to {
            opacity: 1;

        }
    }

    .order-card {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 1000;
        animation: fadeInFromLeft 0.5s ease-out; /* Adjust the animation duration and easing as needed */
    }


     .m-5 {
        perspective: 1000px;
        transition: transform 0.5s;
    }

    .bg-secondary {
        border-radius: 20px;
        box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
        transition: transform 0.5s;
    }

    .bg-secondary:hover {
        transform: rotateY(20deg);
    }

    .view-button {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.5s;
    }

    .m-5:hover .view-button {
        opacity: 1;
    }
    .software-checkboxes {
        display: flex;
        flex-direction: column;
        margin: 20px;
    }
    .form-check {
        display: flex;
        align-items: center;
    }
</style>
<script>
// Function to show the "Ordering Please Wait!" card and submit the form
function submitOrderForm(button) {
    var bagoongId = button.getAttribute('data-bagoong-id');
    var orderCard = document.getElementById('orderCard_' + bagoongId);
    orderCard.style.display = 'block';

    // Submit the form after showing the card
    var orderForm = document.getElementById('orderForm_' + bagoongId);
    orderForm.submit();
}


   function updateSelectedSoftware() {
        const checkboxes = document.querySelectorAll('input[name="software"]');
        const selectedSoftware = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedSoftware.push(checkbox.value);
            }
        });

        const selectedSoftwareInput = document.getElementById('daws');
        selectedSoftwareInput.value = selectedSoftware.join(', '); // or use any other delimiter you prefer
    }
</script>

@endsection
@auth

@endauth

