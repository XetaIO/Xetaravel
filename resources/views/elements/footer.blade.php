<footer class="footer">
	<div class="container">
		<div class="row  p-1">
			<div class="col-md-8">

				<div class="row">
					<div class="col-md-6">
						<h5 class="mb-1">Utils</h5>
						<ul class="pl-0">
							<li class="mb-1">
								{{ link_to(route('users.auth.register'), '<i class="fa fa-user-plus"></i> Register', ['class' => 'btn btn-outline-info'], null, false) }}
							</li>
							<li class="mb-1">
								{{ link_to(route('users.auth.login'), '<i class="fa fa-sign-in"></i> Login', ['class' => 'btn btn-outline-primary'], null, false) }}
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

					<div class="col-md-6">
						<h5 class="mb-1">Extra</h5>
						<ul class="pl-0">
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
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<h5 class="mb-1">Subscriber to get the latest news !</h5>

				 <div class="input-group mb-1">
						<form method="POST" action="{{ route('newsletter.subscribe') }}" accept-charset="UTF-8" style="display: contents;">

						<input placeholder="Your E-mail..." required="required" name="search" type="email" id="newsletter" class="form-control">

						{!! Form::token(); !!}

                        {!! Form::button('<i class="far fa-paper-plane"></i> Subscribe', ['type' => 'submit', 'class' => 'input-group-addon btn btn-outline-primary']) !!}
                    </form>
                    </div>

			</div>
		</div>

		<div class="row pb-1">
			<div class="col-md-12 text-md-center">
				&copy; {{ date('Y', time()) }} {{ config('app.name') }}. All rights reserved.
				<br/>
				<i class="fa fa-code text-primary" style="font-weight: bold;"></i> with <i class="fa fa-heart" style="color: #fa6c65"></i> and <i class="fa fa-coffee" style="color: #826644"></i> by <a href="https://github.com/Xety" target="_blank">@Emeric</a>
				<br/>
				Hosted with <a href="https://forge.laravel.com" target="_blank">Laravel Forge</a> and <a href="https://www.digitalocean.com" target="_blank">DigitalOcean</a>
			</div>
		</div>
	</div>
</footer>
