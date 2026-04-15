@extends('layouts.app')

@section('content')
<div class="navbar">
    <h1 style="margin: 0;">Freedom Board</h1>
    <div>
        @auth
            <span class="user-info">Welcome, <strong>{{ auth()->user()->username }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#1976d2;cursor:pointer;font-size:1em;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</div>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="search-container">
    <form action="{{ route('posts.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search authors or topics..." value="{{ $search ?? '' }}">
        <button type="submit">Search</button>
        @if(!empty($search))
            <a href="{{ route('posts.index') }}" style="margin-left: 10px; font-size: 0.9em;">Clear</a>
        @endif
    </form>
</div>

@auth
    <form action="{{ route('posts.store') }}" method="POST" class="post-form">
        @csrf
        <textarea name="content" placeholder="Write a message..." required></textarea><br>
        <button type="submit">Post to Board</button>
    </form>
@else
    <p style="text-align: center; margin: 20px;">Please <a href="{{ route('login') }}">login</a> to post a message.</p>
@endauth

<hr>
<h2>Messages</h2>

<div class="board-container">
    @if($posts->count())
        @foreach($posts as $post)
            <div class="post">
                <strong>{{ $post->user->username ?? 'Unknown' }}</strong>:
                {{ $post->content }}
                <div class="meta">Posted on: {{ $post->created_at->format('Y-m-d H:i') }}</div>
                <div class="actions">
                    @auth
                        <a href="#" onclick="document.getElementById('reply-form-{{ $post->id }}').style.display='block'; return false;">Reply</a>
                    @endauth
                    @if(auth()->check() && $post->user_id == auth()->id())
                        | <form action="{{ route('posts.remove', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                        </form>
                    @endif
                </div>
                <div id="reply-form-{{ $post->id }}" class="reply-form" style="display: none;">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $post->id }}">
                        <textarea name="content" placeholder="Write a reply..." required></textarea>
                        <button type="submit">Send Reply</button>
                    </form>
                </div>
                @foreach($post->replies as $reply)
                    <div class="post reply">
                        <strong>↳ {{ $reply->user->username ?? 'Unknown' }}</strong>:
                        {{ $reply->content }}
                        <div class="meta">Posted on: {{ $reply->created_at->format('Y-m-d H:i') }}</div>
                        @if(auth()->check() && $reply->user_id == auth()->id())
                            <form action="{{ route('posts.remove', $reply) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this reply?')">Delete</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    @else
        <p>No messages found.</p>
    @endif
</div>

<div class="pagination">
    {{ $posts->links() }}
</div>

<script>
    // this is to fetch the latest max ID from the DB every 5 seconds
    const initialMaxId = @json(\DB::table('posts')->max('id') ?? 0);
    setInterval(() => {
        fetch('/src/posts/poll.php')
            .then(r => r.text())
            .then(latestId => {
                if (parseInt(latestId) > initialMaxId) {
                    location.reload();
                }
            });
    }, 5000);
</script>
@endsection