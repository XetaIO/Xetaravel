<footer class="footer">
	<div class="container">
		<div class="row  p-1">
			<div class="col-md-8">

				<div class="row">
					<div class="col-md-6">
						<h3 class="footer-title mb-1">Utils</h3>
						<ul class="list-unstyled">
							@notauth
								<li class="mb-1">
									{{ link_to(route('users.auth.register'), '<i class="fa fa-user-plus"></i> Register', ['class' => 'btn btn-outline-primary-inverse'], null, false) }}
								</li>
								<li class="mb-1">
									{{ link_to(route('users.auth.login'), '<i class="fa fa-sign-in"></i> Login', ['class' => 'btn btn-outline-primary'], null, false) }}
								</li>
							@endauth
							<li class="mb-1">
								<a href="{{ route('blog.article.index') }}">
									Blog
								</a>
							</li>
							<li class="mb-1">
								<a href="{{ route('discuss.index') }}">
									Discuss
								</a>
							</li>
						</ul>
					</div>

					<div class="col-md-6">
						<h3 class="footer-title mb-1">Extra</h3>
						<ul class="list-unstyled">
							<li class="mb-1">
								<a href="{{ route('page.terms') }}">
									Terms
								</a>
							</li>
							<li class="mb-1">
								<a href="{{ route('page.contact') }}">
									Contact
								</a>
							</li>
							<li class="mb-1">
								<a href="{{ config('xetaravel.site.github_url') }}" target="_blank">
									<i class="fa fa-github-alt" data-toggle="tooltip" title="Source Code available on Github"></i> Source Code
								</a>
							</li>
							@if (config('xetaravel.version'))
								<li class="mb-1">
									<small>Version : {{ config('xetaravel.version') }}</small>
								</li>
							@endif
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<h3 class="footer-title mb-1">Subscribe to get the latest news !</h3>

				 <div class="input-group mb-1">
					{!! Form::open(['route' => 'newsletter.subscribe']) !!}

						{!! Form::bsNewsletter('email', null, null, [
                                'placeholder' => 'Your E-mail...',
                                'required' => 'required'
                            ]) !!}

                	{!! Form::close() !!}
                </div>

			</div>
		</div>

		<div class="row pb-1">
			<div class="col-md-12 text-md-center">
				<div>
					&copy; {{ date('Y', time()) }} {{ config('app.name') }}. All rights reserved.
				</div>
				<div>
					<i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-heart" style="color: #fa6c65"></i> and <i class="fa fa-coffee" style="color: #826644"></i> by <a href="https://github.com/Xety" target="_blank">@Emeric</a>
				</div>
				<div>
					Hosted with <a href="https://forge.laravel.com" target="_blank">Laravel Forge</a> and <a href="https://www.digitalocean.com" target="_blank">DigitalOcean</a>
				</div>
			</div>
		</div>
	</div>
</footer>
