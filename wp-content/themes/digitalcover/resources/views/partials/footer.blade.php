<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-auto">
        <div class="footer__links">
          @if (is_front_page())
            <div class="footer__links-credit">
              <a class="link" href="https://digital-cover.fr/" target="_blank" rel="noopener">Création de site internet</a>
              {{ display_svg('dc') }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</footer>
