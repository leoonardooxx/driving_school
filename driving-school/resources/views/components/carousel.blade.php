@props([
'images' => [],
])

<div class="w-full max-w-5xl">
    <div class="relative overflow-hidden rounded-2xl">
        <div class="carousel flex transition-transform duration-700 ease-in-out">
            @foreach ($images as $image)
            <div class="min-w-full flex justify-center">
                <img src="{{ asset($image) }}" alt="Customer testimonial"
                    class="w-full max-w-3xl h-auto object-cover rounded-2xl">
            </div>
            @endforeach
        </div>

        <x-layout.button type="button" icon="lucide-chevron-left" theme="white"
            class="carousel-previous absolute left-4 top-1/2 -translate-y-1/2" />

        {{-- Next --}}
        <x-layout.button type="button" theme="white" icon="lucide-chevron-right"
            class="carousel-next absolute right-4 top-1/2 -translate-y-1/2" />
    </div>
    
    <div class="carousel-dots flex justify-center gap-2 mt-6">
        @foreach ($images as $index => $image)
        <button type="button"
            class="carousel-dot h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-6 bg-black' : 'w-2.5 bg-gray-300' }}"></button>
        @endforeach
    </div>

</div>

<script>
    document.querySelectorAll('.carousel').forEach((carousel) => {
        const container = carousel.closest('div.w-full');
        const previousButton = container.querySelector('.carousel-previous');
        const nextButton = container.querySelector('.carousel-next');
        const dots = container.querySelectorAll('.carousel-dot');

        let current = 0;
        const total = dots.length;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${current * 100}%)`;

            dots.forEach((dot, index) => {
                if (index === current) {
                    dot.classList.remove('w-2.5', 'bg-gray-300');
                    dot.classList.add('w-6', 'bg-black');
                } else {
                    dot.classList.remove('w-6', 'bg-black');
                    dot.classList.add('w-2.5', 'bg-gray-300');
                }
            });
        }

        function nextSlide() {
            current = (current + 1) % total;
            updateCarousel();
        }

        function previousSlide() {
            current = (current - 1 + total) % total;
            updateCarousel();
        }

        nextButton.addEventListener('click', previousSlide);
        previousButton.addEventListener('click', previousSlide);

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                current = index;
                updateCarousel();
            });
        });

        setInterval(nextSlide, 4000);
    });
</script>
