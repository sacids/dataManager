<?php if (isset($events_map)): ?>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjO8E4UMo5tGs5U9HQ6zLmVQBa3k7UYIs&callback=initMap">
    </script>

<?php else: ?>
    <!--footer-->
    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">AfyaData Moçambique. &copy; <?= date('Y')?> -  Todos direitos reservados</p>
        </div>
        <!-- /.container -->
    </footer>
<?php endif; ?>

</body>
</html>