    <script>
        window.conversationId = "{{ $conversation->id }}";
        window.messageStoreRoute = "{{ route('messages.store') }}";
        window.authUserId = "{{ auth()->id() }}";
        window.authUserName = "{{ auth()->user()->name }}";
        window.markAsReadRoute = "{{ route('messages.markAsRead', ['conversationId' => ':conversationId']) }}";
    </script>

