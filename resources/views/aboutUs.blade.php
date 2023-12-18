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

                @if (Auth::check())
                <button class="text-white rounded-lg pe-4 ps-4 text-danger btn" style="background-color: transparent; font-size: 20px;" id="logoutButton" data-toggle="modal" data-target="#confirmLogoutModal">
                    <i class="fa-solid fa-right-from-bracket"></i> {{ Auth::user()->name }}
                </button>
            @endif

            </div>
        </div>
    </header>

    <div class="text-dark">
        <div class="p-5">
            <div style="margin-top: 100px; display: grid; place-content: center;">
                <div style="width: 1000px;">
                    <div class="store-card">
                        <div class="card-header">
                            <h1>Contact Us</h1>
                        </div>
                        <div class="card-body">
                            <div class="contact-form">
                                <h2>Have a question or feedback?</h2>

                                <div class="order-card" id="feedbackCard" style="border-radius: 50px; text-align: center; width: 500px; color: black; display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); z-index: 1000;">
                                    <h3>Sending Feedback, Please Wait!</h3>
                                </div>

                                <form method="post" action="{{ route('submitFeedback') }}" id="feedbackForm">
                                    @csrf <!-- Laravel CSRF token -->

                                    <div class="form-group">
                                        <label for="feedback">Your Feedback:</label>
                                        <textarea class="form-control" name="feedback" id="feedback" cols="30" rows="5"></textarea>
                                    </div>

                                    <button type="button" class="btn btn-primary" onclick="submitFeedbackForm()">
                                        <i class="fas fa-paper-plane"></i> Submit Feedback
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p>Feel free to reach out to us via email at <a href="mailto:info@store.com">info@store.com</a></p>
                            <div class="social-icons">
                                <a href="#" class="icon-link"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="icon-link"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="icon-link"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
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
    // Function to show the "Sending Feedback, Please Wait!" card and submit the form
    function submitFeedbackForm() {
        var feedbackCard = document.getElementById('feedbackCard');
        feedbackCard.style.display = 'block';

        // Disable the submit button to prevent multiple submissions
        document.getElementById('feedbackForm').querySelector('button').disabled = true;

        // Submit the form after showing the card
        document.getElementById('feedbackForm').submit();
    }
</script>

@endsection
