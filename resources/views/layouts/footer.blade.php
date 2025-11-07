    </main>
    <footer style="padding:1rem;background:#fafafa;border-top:1px solid #eee;margin-top:2rem;">
        <div style="max-width:1100px;margin:0 auto;text-align:center;color:#666;">
            &copy; {{ date('Y') }} My Alumni App
        </div>
    </footer>

    {{-- Optional app JS (uncomment if exists) --}}
    @if (file_exists(public_path('js/app.js')))
        <script src="{{ asset('js/app.js') }}"></script>
    @endif
    </body>

    </html>
    {{-- footer --}}
    <footer>
        <p>&copy; 2024 Alumni SV TPL. All rights reserved.</p>
    </footer>
    </body>

    </html>
