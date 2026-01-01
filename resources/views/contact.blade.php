<x-app-layout>
    <div class="container py-5">
        
        {{-- SECTION 1: CONTACT INFO CARDS --}}
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-5 text-center">
                
                <h2 class="fw-bold text-primary mb-5">Contact Us</h2>

                <div class="row g-4">
                    {{-- 1. PHONE --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="bi bi-phone text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="fw-bold">Phone No.</h5>
                        <p class="text-muted mb-0">-Admin-</p>
                        <p class="fw-bold lead">011-37383739</p>
                    </div>

                    {{-- 2. EMAIL --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="bi bi-envelope-open text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="fw-bold">E-mail</h5>
                        <p class="text-muted">kampungsentosa@eaduan.com</p>
                    </div>

                    {{-- 3. ADDRESS --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="bi bi-geo-alt-fill text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="fw-bold">Address</h5>
                        <p class="text-muted">
                            Kampung Sentosa, 50300,<br>
                            Kuala Lumpur
                        </p>
                    </div>

                    {{-- 4. OPERATING HOURS --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <i class="bi bi-clock-history text-danger" style="font-size: 2.5rem;"></i>
                        </div>
                        <h5 class="fw-bold">Service Hours</h5>
                        <ul class="list-unstyled text-muted small">
                            <li>Monday: 9:00am - 10:00pm</li>
                            <li>Tuesday: 9:00am - 10:00pm</li>
                            <li>Wednesday: 9:00am - 10:00pm</li>
                            <li>Thursday: 9:00am - 10:00pm</li>
                            <li>Friday: 9:00am - 8:00pm</li>
                            <li>Saturday: 9:00am - 8:00pm</li>
                            <li>Sunday: 9:00am - 8:00pm</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        {{-- SECTION 2: GOOGLE MAP --}}
        <div class="text-center">
            <h3 class="fw-bold mb-4">Our Location</h3>
            <div class="card shadow-sm border-0 overflow-hidden">
                {{-- 
                    Google Map Embed
                    You can replace the "src" below with your exact location link from Google Maps if needed.
                --}}
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.452899745354!2d101.693202!3d3.147273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc3627a810d29f%3A0x63391740924976f6!2sKuala%20Lumpur!5e0!3m2!1sen!2smy!4v1689234567890!5m2!1sen!2smy" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>
</x-app-layout>