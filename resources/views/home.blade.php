@extends('layouts.app')

@section('content')
<style>
    .home-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 75vh;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        text-align: center;
    }
    
    .home-text {
        margin-bottom: 40px; /* Space between text stack and button */
    }

    .home-text h1 {
        font-family: inherit; 
        font-size: 6.5rem; /* Large chunky sizing */
        font-weight: 900;
        color: #a4232a; /* Deep Red */
        line-height: 1.1;
        letter-spacing: -2px;
        text-transform: uppercase;
        margin: 0;
        text-shadow: 4px 4px 15px rgba(0, 0, 0, 0.7);
    }

    .home-btn-order {
        background-color: #a4232a;
        color: white;
        border-radius: 50px;
        padding: 10px 35px; /* Smaller padding */
        font-size: 1rem; /* Smaller font */
        font-weight: 800;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        transition: transform 0.2s, background-color 0.2s;
        text-transform: uppercase;
    }

    .home-btn-order:hover {
        background-color: #8f1d24;
        transform: translateY(-2px);
        color: white;
    }

    @media (max-width: 900px) {
        .home-text h1 {
            font-size: 4rem;
        }
    }
</style>

<div class="home-container">
    <div class="home-text">
        <h1>
            ENAK<br>
            MURAH<br>
            NAGIH
        </h1>
    </div>
    <a href="{{ route('menu') }}" class="home-btn-order">ORDER NOW!</a>
</div>
@endsection