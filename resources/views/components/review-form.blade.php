{{-- Enhanced Review Form Partial --}}
<div class="mt-12 p-8 md:p-10 bg-white rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 bg-pink-100/30 rounded-full blur-3xl"></div>
    
    <h3 class="text-2xl font-extrabold text-gray-900 mb-8 tracking-tight">
        Bagikan Pengalaman Anda
    </h3>

    <form id="reviewForm" class="space-y-6 relative z-10">
        @csrf
        <input type="hidden" name="reviewable_type" value="{{ $reviewableType }}">
        <input type="hidden" name="reviewable_id" value="{{ $reviewableId }}">
        
        <div class="space-y-3">
            <label class="block text-sm font-bold text-gray-700">Berikan Rating</label>
            <div class="flex gap-2" id="ratingContainer">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" 
                        onclick="setRating({{$i}})" 
                        onmouseover="hoverRating({{$i}})"
                        onmouseout="resetRating()"
                        class="rating-star text-4xl transition-all duration-200 focus:outline-none" 
                        data-value="{{$i}}">
                        <span class="star-char text-gray-300">★</span>
                    </button>
                @endfor
            </div>
            <input type="hidden" name="rating" id="ratingInput" value="5" required>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-3">Tulis Ulasan Anda</label>
            <textarea name="comment" rows="4" class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all resize-none" placeholder="Bagaimana pengalaman Anda? Ceritakan pengalaman seru Anda di sini..."></textarea>
        </div>
        
        <button type="submit" id="submitReviewBtn" class="w-full bg-pink-600 text-white px-8 py-4 rounded-2xl font-bold hover:bg-pink-500 transition-all hover:-translate-y-1 shadow-lg shadow-pink-600/30">
            Kirim Ulasan Sekarang
        </button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Star Rating Logic
    let currentRating = 5;

    function updateStarsDisplay(val) {
        document.querySelectorAll('.rating-star').forEach((star, index) => {
            const starChar = star.querySelector('.star-char');
            if (index < val) {
                starChar.classList.remove('text-gray-300');
                starChar.classList.add('text-yellow-400');
                star.classList.add('scale-110');
            } else {
                starChar.classList.add('text-gray-300');
                starChar.classList.remove('text-yellow-400');
                star.classList.remove('scale-110');
            }
        });
    }

    function setRating(val) {
        currentRating = val;
        document.getElementById('ratingInput').value = val;
        updateStarsDisplay(val);
    }

    function hoverRating(val) {
        updateStarsDisplay(val);
    }

    function resetRating() {
        updateStarsDisplay(currentRating);
    }

    // Initialize
    setRating(5);

    document.getElementById('reviewForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitReviewBtn');
        btn.disabled = true;
        btn.innerText = 'Mengirim...';

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        try {
            const response = await fetch('/api/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(data)
            });
            
            if (response.ok) {
                Toast.fire({
                    icon: 'success',
                    title: 'Ulasan berhasil dikirim!'
                });
                setTimeout(() => location.reload(), 1500);
            } else {
                const err = await response.json();
                Toast.fire({
                    icon: 'error',
                    title: err.message || 'Gagal mengirim ulasan.'
                });
                btn.disabled = false;
                btn.innerText = 'Kirim Ulasan Sekarang';
            }
        } catch (error) {
            console.error('Error:', error);
            Toast.fire({
                icon: 'error',
                title: 'Terjadi kesalahan sistem.'
            });
            btn.disabled = false;
            btn.innerText = 'Kirim Ulasan Sekarang';
        }
    });
</script>