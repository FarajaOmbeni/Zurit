<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Firmbee.com - Free Project Management Platform for remote teams">
    <title>Contact @ Zurit</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0e035b9984.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="{{ asset('img/ico_logo.png') }}">
</head>

<body>
    <nav class="navbar nav-dark navbar-expand-lg fixed-top py-3">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="{{ asset('img/logo-white3.png') }}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('about') }}">About us</a>
                    </li>
                    <li
                        class="nav-item dropdown d-md-inline {{ Request::is('budgetplanner', 'networthcalculator', 'debtmanager', 'investmentplanner') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="prosperityToolsDropdown" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Prosperity Tools
                        </a>
                        <div class="dropdown-menu" aria-labelledby="prosperityToolsDropdown">
                            <a class="dropdown-item" href="{{ url('budgetplanner') }}">Budget Planner</a>
                            <a class="dropdown-item" href="{{ url('networthcalculator') }}">Networth Calculator</a>
                            <a class="dropdown-item" href="{{ url('debtmanager') }}">Debt Manager</a>
                            <a class="dropdown-item" href="{{ url('investmentplanner') }}">Investment Planner</a>
                        </div>
                    </li>
                    <li class="nav-item {{ Request::is('training') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('training') }}">Training</a>
                    </li>
                    <!--<li class="nav-item {{ Request::is('advisory') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('advisory') }}">Advisory</a>
                </li>-->
                    <li class="nav-item {{ Request::is('books') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('books') }}">Books</a>
                    </li>
                    <li class="nav-item {{ Request::is('blogs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('blogs') }}">Blogs</a>
                    </li>
                    <li class="nav-item {{ Request::is('contactus') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('contactus') }}">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('login') }}"><button class="btn-item">Join Us</button></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mainmargin">
        <div class="row">
            <section class="feedback-form" style="display: block">
                <h2 style="text-align: center;">Customer Feedback</h2>
                <form action="/give-feedback" method="POST">
                    @csrf
                    <!--Rating Questions-->
                    <label for="name">Name of the Event</label>
                    <select name="name" id="name">
                        @if ($events->isempty())
                            <option selected disabled>No events available</option>
                        @else
                            @foreach ($events as $event)
                                <option value="{{ $event->name }}">{{ $event->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <label for="venue">Please rate the overall organization and logistics of the training sessions
                        (e.g., venue, scheduling, facilities).
                    </label>
                    <select name="venue" id="" required>
                        <option value="1">1 - Disorganized</option>
                        <option value="2">2 - Kind of Organized</option>
                        <option value="3">3 - Fair</option>
                        <option value="4">4 - Adequate</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                    <label for="comprehensiveness">How satisfied are you with the clarity and comprehensiveness of the
                        topics covered during the training sessions?
                    </label>
                    <select name="comprehensiveness" id="" required>
                        <option value="1">1 - Confusing</option>
                        <option value="2">2 - Somewhat Clear</option>
                        <option value="3">3 - Fair</option>
                        <option value="4">4 - Clear</option>
                        <option value="5">5 - Very Comprehensive</option>
                    </select>
                    <label for="relevance">How would you rate the relevance of the topics covered in our training
                        sessions to your financial goals and needs?
                    </label>
                    <select name="relevance" id="" required>
                        <option value="1">1 - Irrelevant</option>
                        <option value="2">2 - Somewhat relevant</option>
                        <option value="3">3 - Moderately relevant</option>
                        <option value="4">4 - Very relevant</option>
                        <option value="5">5 - Extremely relevant</option>
                    </select>
                    <label for="recommendation">How likely are you to recommend Zurit Consulting's trainings to others
                        based on your experience?
                    </label>
                    <select name="recommendation" id="" required>
                        <option value="1">1 - Unlikely</option>
                        <option value="2">2 - Less Likely</option>
                        <option value="3">3 - Neutral</option>
                        <option value="4">4 - Likely</option>
                        <option value="5">5 - Very Likely</option>
                    </select>
                    <label for="return_client">How likely are you to attend other Zurit Consulting's trainings based on
                        your experience?
                    </label>
                    <select name="return_client" id="" required>
                        <option value="1">1 - Unlikely</option>
                        <option value="2">2 - Less Likely</option>
                        <option value="3">3 - Neutral</option>
                        <option value="4">4 - Likely</option>
                        <option value="5">5 - Very Likely</option>
                    </select>
                    <label for="value_for_money">Please rate the value for money of the financial training and services
                        provided by Zurit Consulting.
                    </label>
                    <select name="value_for_money" id="" required>
                        <option value="1">1 - No Value</option>
                        <option value="2">2 - Poor Value</option>
                        <option value="3">3 - Fair Value</option>
                        <option value="4">4 - Good Value</option>
                        <option value="5">5 - Excellent Value</option>
                    </select>

                    <!--Open ended Questions-->
                    <label for="valuable_aspect">What aspects of our training sessions did you find most valuable?
                    </label>
                    <textarea rows="4" type="text" name="valuable_aspect" required></textarea>
                    <label for="improvement">Is there anything specific that you feel could be improved about our
                        training programs?
                    </label>
                    <textarea rows="4" type="text" name="improvement" required></textarea>
                    <label for="suggestion">Are there any additional topics or areas of interest you would like to see
                        covered in future training sessions?</label>
                    <textarea rows="4" type="text" name="suggestion" required></textarea>
                    <label for="improve_experience">Do you have any suggestions or ideas for how we can enhance the
                        overall customer experience during our training sessions?</label>
                    <textarea rows="4" type="text" name="improve_experience" required></textarea>
                    <label for="fav_trainor">Who was your favourite trainor/trainors?</label>
                    <textarea rows="4" type="text" name="fav_trainor" required></textarea>
                    <label for="testimonial">Kindly tell us what you think about our trainings in general</label>
                    <textarea rows="4" type="text" name="testimonial" required></textarea>
                    <button class="feedback-button" type="submit">Submit</button>
                </form>
            </section>
            <section class="contact-us" id="contact-us">
                <div class="container">
                    <h2>Contact Us</h2>
                    <div class="contact-content d-flex flex-column flex-lg-row">
                        <div class="map mb-4 mb-lg-0">
                            <!-- Embed your map here -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.772966870618!2d36.79918977496576!3d-1.3116021986759463!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f139a2af6edab%3A0xa6fa99525e66f680!2sZuidier%20Ltd.!5e0!3m2!1sen!2ske!4v1699780330698!5m2!1sen!2ske"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="contact-form">
                            <form action="{{ route('contact.store') }}" method="post">
                                @csrf
                                <input type="text" name="name" placeholder="Your Name">
                                <input type="email" name="email" placeholder="Your Email">
                                <textarea name="userMessage" placeholder="Your Message"></textarea>
                                <button type="submit">Send Message</button>
                            </form>
                            <div class="contact-icons">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                    <p>+254 759 092 412</p>
                                </div>
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p>Zuidier Complex, <br>Mbagathi Hospital Road<br>Off Mbagathi Way</p>
                                </div>
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                    <p>info@zuritconsulting.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </div>

    <footer class="py-5">
        <div class="container">
            <div class="row">
                <div class="footer-item col-md-3">
                    <!--<img src="img/logo-white3.png" style="width: 50% height: 50%"alt="">-->
                    <p>Address: Zuidier Complex</p>
                    <p>Ngumo, Off Mbagathi Road</p>
                    <p>Nairobi, KE </p>
                    <p>Phone: +254 759 092 412</p>
                    <p>Email: info@zuritconsulting.com</p>
                </div>
                <div class="footer-item col-md-3">
                    <p class="footer-item-title">Services</p>
                    <p class="footer-text">Budget Management:</p>
                    <p>Financial Training</p>
                    <p>Investment Advisory</p>
                    <p>Debt Management</p>
                </div>
                <div class="footer-item col-md-3">
                    <p class="footer-item-title">Links</p>
                    <a href="">About Us</a>
                    <a href="">Home</a>
                    <a href="">Training</a>
                    <a href="">Contact Us</a>
                </div>
                <div class="footer-item col-md-3">
                    <p class="footer-item-title">Get In Touch</p>
                    <form action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <div class="mb-3 pb-3">
                            <label for="exampleInputEmail1" class="form-label pb-3">Enter your email and we'll send
                                you more information.</label>
                            <input type="email" name="email" placeholder="Your Email" class="form-control"
                                id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
                <div class="copyright pt-4 text-center text-muted">
                    <p>&copy; {{ date('Y') }} ZURIT CONSULTING</p>

                </div>
            </div>
    </footer>
    </main>
    <div class="fb2022-copy">Fbee 2022 copyright</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/addshadow.js"></script>
</body>

</html>
