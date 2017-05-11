<footer class="footer">
  <div class="container">
      <div class="row">
        <div class="col-md-6">
              &copy; {{ date('Y', time()) }} {{ config('app.name') }}.
          <ul class="list-inline d-inline-block mb-0">
            <li class="list-inline-item">
              <a href="{{ config('xetaravel.site.github_url') }}" target="_blank">
                <i class="fa fa-github-alt" data-toggle="tooltip" title="Source Code available on Github"></i>
              </a>
            </li>
          </ul>
        </div>

        <div class="col-md-6 text-md-right">
          <i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-heart" style="color: #fa6c65"></i> and <i class="fa fa-coffee" style="color: #826644"></i> by <a href="https://github.com/Xety" target="_blank">@Xeta</a>
        </div>
    </div>
  </div>
</footer>
