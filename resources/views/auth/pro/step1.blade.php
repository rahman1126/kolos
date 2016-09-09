@extends('auth.register')
@section('content')


<div class="col-md-4 col-md-offset-2">
    <div class="media">
        <div class="media-left">
            <div class="icon">
                <i class="pe-7s-diamond"></i>
            </div>
        </div>
        <div class="media-body">
            <h4>Opportunity</h4>
            Join Indonesia’s Biggest and fastest growing Marketplace for Professional Services.
        </div>
    </div>

    <div class="media">
        <div class="media-left">
            <div class="icon">
                <i class="pe-7s-coffee"></i>
            </div>
        </div>
        <div class="media-body">
            <h4>Freedom</h4>
            Create, customize your profile, Setup Opening and closing time, send Promos to your Followers.
        </div>
    </div>

    <div class="media">
        <div class="media-left">
            <div class="icon">
                <i class="pe-7s-graph1"></i>
            </div>
        </div>
        <div class="media-body">
            <h4>Growth</h4>
            Get extra Order by increasing not only your visibility but also Home delivery services to Increase your customer base.
        </div>
    </div>

</div>
<div class="col-md-4 col-md-offset-s1">
    <form role="form" method="POST" action="{{ url('/register/pro/nextone') }}">
        {!! csrf_field() !!}
        <div class="card card-plain">
            <div class="content">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" class="form-control {{ ($errors->has('name') ? 'error' : '') }}" value="{{ old('name') }}">
                </div>
                <!-- <div class="form-group">
                    <select name="cities" class="selectpicker" data-title="Single Select" data-style="btn-default btn-block" data-menu-style="dropdown-blue" tabindex="-98"><option class="bs-title-option" value="">Single Select</option>
                            <option value="id">Bahasa Indonesia</option>
                            <option value="ms">Bahasa Melayu</option>
                            <option value="ca">Català</option>
                            <option value="da">Dansk</option>
                            <option value="de">Deutsch</option>
                            <option value="en">English</option>
                            <option value="es">Español</option>
                            <option value="el">Eλληνικά</option>
                            <option value="fr">Français</option>
                            <option value="it">Italiano</option>
                            <option value="hu">Magyar</option>
                        </select>
                </div> -->
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" class="form-control {{ ($errors->has('email') ? 'error' : '') }}" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input type="text" name="phone" placeholder="Phone Number" class="form-control {{ ($errors->has('phone') ? 'error' : '') }}" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <input type="text" name="company" placeholder="Company" class="form-control {{ ($errors->has('company') ? 'error' : '') }}" value="{{ old('company') }}">
                </div>

                <div class="form-group">
                    <select class="selectpicker" name="category" data-title="Select Category" data-style="btn-default btn-block" data-menu-style="dropdown-blue" tabindex="-98">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" class="form-control {{ ($errors->has('password') ? 'error' : '') }}" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="form-control">
                </div>
            </div>
            <div class="footer text-center">
                <button type="submit" class="btn btn-fill btn-warning btn-wd">Become a Merchant</button>
            </div>
        </div>
    </form>

</div>


@stop
