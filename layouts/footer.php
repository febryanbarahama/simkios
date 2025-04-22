</main>
</div> <!-- Tutup container -->
    
<footer class="bg-light text-center py-3 mt-auto">
            <div class="container">
                <p class="mb-0">&copy; <?= date('Y'); ?> SimKios - Dibuat dengan ❤️ oleh Bryann</p>
            </div>
        </footer>
    </div> <!-- Tutup wrapper utama -->
    
    <!-- JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
  // Hapus parameter URL agar alert tidak muncul saat refresh
  if (window.history.replaceState) {
    const url = new URL(window.location);
    url.search = '';
    window.history.replaceState({}, document.title, url);
  }
</script>

</body>
</html>
