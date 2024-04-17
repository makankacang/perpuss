@foreach ($otherReviews as $review)
    <hr>
    <div class="mb-3">
        <p><strong>User:</strong> {{ $review->user->name }}</p>
        <p><strong>Rating:</strong> 
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $review->Rating)
                    <i class="fas fa-star text-warning"></i>
                @else
                    <i class="far fa-star text-warning"></i>
                @endif
            @endfor
        </p>
        <p><strong>Ulasan:</strong> {{ $review->Ulasan }}</p>
    </div>
    <hr>
@endforeach
