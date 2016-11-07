<div data-popup="login" class="popup-overlay" id="login-popup">
    <div class="popup popup-sm">
        <span class="icon icon-close"></span>
        <div class="popup-wrapper">
            <div class="popup-header">
                <h5>Вход в систему</h5>
            </div>
            <div class="popup-body">
                {!! Form::open(['route' => 'login.post']) !!}
                    @include('flash::message')
                    <div class="form-group">
                        <input type="text" required="required" name="phone" data-mask="" placeholder="Телефон" data-inputmask='"mask": "{!! config('village.user.phone.mask') !!}"' class="form-control {{ $errors->has('phone') ? ' field-error' : '' }}" />
                        {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Пароль" class="form-control {{ $errors->has('password') ? ' field-error' : '' }}" />
                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="checkbox-container">
                        <input type="checkbox" data-tooltip="result" id="remember-me" name="remember_me" />
                        <label for="remember-me">{{ trans('user::auth.remember me') }}</label>
                        <a href="#" data-popup-link="registration" class="forgot-password">Забыли пароль?</a>
                        <a href="#" data-popup-link="confirm" class="forgot-password">Ввести код</a>
                    </div>
                    <div class="form-group">
                        <div class="btn-wrapper">
                            <button class="btn-main">{{ trans('user::auth.login') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div data-popup="confirm" class="popup-overlay" id="confirm-popup">
    <div class="popup popup-sm">
        <span class="icon icon-close"></span>
        <div class="popup-wrapper">
            <div class="popup-header">
                <h5>Подтверждение регистрации</h5>
            </div>
            <div class="popup-body">
                {!! Form::open(['route' => 'login.post']) !!}
                    <div class="form-group">
                        <input type="text" required="required" name="phone" data-mask="" placeholder="Ваш телефон" data-inputmask='"mask": "{!! config('village.user.phone.mask') !!}"' name="phone" placeholder="Телефон" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Пароль" required="required" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="Повторите пароль" required="required" class="form-control" />
                    </div>
                <div class="form-group">
                    <input type="text" name="code" placeholder="Код подвреждения" required="required" class="form-control" />
                </div>
                    <div class="form-group">
                        <div class="btn-wrapper">
                            <button class="btn-main">{{ trans('user::auth.login') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div data-popup="change-password" class="popup-overlay" id="change-password">
    <div class="popup popup-sm">
        <span class="icon icon-close"></span>
        <div class="popup-wrapper">
            <div class="popup-header">
                <h5>Смена пароля</h5>
            </div>
            <div class="popup-body">
                {!! Form::open(['route' => 'login.post']) !!}
                 <input type="hidden" name="phone" />
                <div class="form-group">
                    <input type="password" name="password" placeholder="Новый пароль" required="required" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Повторите пароль" required="required" class="form-control" />
                </div>
                <div class="form-group">
                    <input type="text" name="code" placeholder="Код подвреждения" required="required" class="form-control" />
                </div>
                <div class="form-group">
                    <div class="btn-wrapper">
                        <button class="btn-main">{{ trans('user::auth.login') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div data-popup="registration" class="popup-overlay">
    <div class="popup popup-sm">
        <span class="icon icon-close"></span>
        <div class="popup-wrapper">
            <div class="popup-header">
                <h5>Восстановление пароля</h5>
            </div>
            <div class="popup-body">
                <p>Для восстановления пароля, пожалуйста, введите номер телефона, прикреплённой к профилю системы “Консьерж”</p>
                <form id="reset-password">
                    <div class="form-group">
                        <input type="text" required="required" name="phone" data-mask="" placeholder="Ваш телефон" data-inputmask='"mask": "{!! config('village.user.phone.mask') !!}"'  class="form-control" />
                    </div>
                    <div class="form-group">
                        <div class="btn-wrapper">
                            <button class="btn-main">Востановить пароль</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div data-popup="map" class="popup-overlay">
    <div class="popup popup-md popup-map"><span class="icon icon-close"></span>
        <div class="popup-wrapper">
            <div class="popup-body">
                <div id="map"></div>
            </div>
        </div>
    </div>
</div>