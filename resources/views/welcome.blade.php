@extends('layouts.web')
@section('content')

<div class="navbar-fixed">
<nav class="transparent">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo"><img src="{{ url('dist/img/logo.png') }}" class="responsive-img"> KOLOS</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#">{{ trans('welcome.downloadapp') }}</a></li>
        <li><a href="{{ url('register/pro') }}" class="modal-trigger">{{ trans('welcome.becomeamerchant') }}</a></li>
      </ul>
    </div>
  </nav>
</div>

<div class="parallax-container valign-wrapper intro" style="background-image: url({{ url('dist/img/bg-kolos.jpg') }}); background-position: 50% 50%; background-size: cover">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row">
          <h3 class="header col m5 offset-m3 light">{{ trans('welcome.title1') }}</h3>
        </div>
        <div class="row">
            <p class="col m4 offset-m3">{{ trans('welcome.subtitle1') }}</p>
            <div class="col m4 offset-m3">
              <a href="#" class="appstore"><img src="{{ url('dist/img/googleplay.png') }}"></a>
              <a href="#" class="appstore"><img src="{{ url('dist/img/appstore.png') }}"></a>
            </div>
        </div>
      </div>
    </div>
  </div>

  <img src="{{ url('dist/img/bg-kolos-3.png') }}" class="responsive-img iphone-img" style="position: absolute; top: 20%; right: 20%; width: 450px;">


<div class="services" style="padding:50px 0">
    <div class="container">
        <div class="row">
            <div class="col m6">
                <h3>{{ trans('welcome.startsomethingnew') }}</h3>
                <p>{{ trans('welcome.desc1') }}</p>
                <p>{{ trans('welcome.desc2') }}:</p>
                <ol>
                    <li>{{ trans('welcome.li1') }}</li>
                    <li>{{ trans('welcome.li2') }}</li>
                    <li>{{ trans('welcome.li3') }}</li>
                    <li>{{ trans('welcome.li4') }}</li>
                </ol>
            </div>
            <div class="col m6" style="padding-top: 18%">
                <p>{{ trans('welcome.desc3') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col m4 item">
                <h3>{{ trans('welcome.ourkey') }}</h3>
                <p>{{ trans('welcome.heresome') }}</p>
            </div>
            <div class="col s12 m4 item" style="background-image: url('{{ url('dist/img/img-massage.jpg') }}'); background-position: 50% 50%; background-size: cover">
                <h3 class="in-image">{{ trans('welcome.item2') }}</h3>
            </div>
            <div class="col s12 m4 item" style="background-image: url({{ url('dist/img/img-serviceac.jpg') }}); background-position: 50% 50%; background-size: cover">
                <h3 class="in-image">{{ trans('welcome.item3') }}</h3>
            </div>

            <div class="col s12 m4 item" style="background-image: url({{ url('dist/img/img-laundry.jpg') }}); background-position: 50% 50%; background-size: cover">
                <h3 class="in-image">{{ trans('welcome.item4') }}</h3>
            </div>
            <div class="col s12 m4 item" style="background-image: url({{ url('dist/img/img-homeservices.jpg') }}); background-position: 50% 50%; background-size: cover">
                <h3 class="in-image">{{ trans('welcome.item5') }}</h3>
            </div>
            <div class="col s12 m4 item" style="background-image: url({{ url('dist/img/img-event.jpg') }}); background-position: 50% 50%; background-size: cover">
                <h3 class="in-image">{{ trans('welcome.item6') }}</h3>
            </div>
        </div>

        <div class="row center" style="padding-top: 20px">
            <h3 class="center">{{ trans('welcome.title3') }}</h3>
            <p><i class="material-icons" style="color: #f06d0f">remove</i></p>
            <div class="col s12 m3">
                <h4>{{ trans('welcome.one') }}</h4>
                <div class="icon-box">
                  <i class="material-icons">search</i>
                </div>
                <p>{{ trans('welcome.step1') }}</p>
            </div>
            <div class="col s12 m3">
                <h4>{{ trans('welcome.two') }}</h4>
                <div class="icon-box">
                  <i class="material-icons">store</i>
                </div>
                <p>{{ trans('welcome.step2') }}</p>
            </div>
            <div class="col s12 m3">
                <h4>{{ trans('welcome.three') }}</h4>
                <div class="icon-box">
                  <i class="material-icons">shopping_cart</i>
                </div>
                <p>{{ trans('welcome.step3') }}</p>
            </div>
            <div class="col s12 m3">
                <h4>{{ trans('welcome.four') }}</h4>
                <div class="icon-box">
                  <i class="material-icons">touch_app</i>
                </div>
                <p>{{ trans('welcome.step4') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="parallax-container valign-wrapper" style="background-image: url({{ url('dist/img/bg-kolos-2.jpg') }}); background-position: 50% 50%; background-size: cover">
    <div class="section">
      <div class="container">
        <div class="row white-text">
          <h3 class="col m7">{{ trans('welcome.title4') }}</h3>
        </div>
        <div class="row white-text">
            <p class="col m6 shadow">{{ trans('welcome.desc4') }}</p>
        </div>
        <div class="row">
            <a href="{{ url('register/pro') }}" class="white-text modal-trigger">{{ trans('welcome.becomeamerchant') }} <i class="material-icons">trending_flat</i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="reason" style="padding: 50px 0">
      <div class="section">
          <div class="container">
              <div class="row">
                  <div class="col m12">
                      <h4>{{ trans('welcome.title5') }}</h4>
                  </div>
                  <div class="col m4">
                      <h5>{{ trans('welcome.title6') }}</h5>
                      <p>{{ trans('welcome.desc6') }}</p>
                  </div>
                  <div class="col m4">
                      <h5>{{ trans('welcome.title7') }}</h5>
                      <p>{{ trans('welcome.desc7') }}</p>
                  </div>
                  <div class="col m4">
                      <h5>{{ trans('welcome.title8') }}</h5>
                      <p>{{ trans('welcome.desc8') }}</p>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="footer">
      <div class="section">
          <div class="container">
              <div class="row">
                  <div class="col m6 footer-up">
                      <h3>{{ trans('welcome.getintouch') }}</h3>
                      <p>{{ trans('welcome.findus') }}</p>
                      <br><br>
                      <p><a class="dropdown-button" href="#" data-activates='dropdown1'><i class="material-icons">language</i> {{ (Request::is('lang/en') ? 'English' : 'Indonesia') }} <i class="material-icons">expand_less</i></a></p>

                      <!-- Dropdown Structure -->
                      <ul id='dropdown1' class='dropdown-content'>
                        <li><a class="black-text" href="{{ url('lang/en') }}">English</a></li>
                        <li><a class="black-text" href="{{ url('lang/id') }}">Indonesia</a></li>
                      </ul>

                  </div>
                  <div class="col m6">
                      <h3>{{ trans('welcome.stayintouch') }}</h3>
                      <form>
                          <div class="row">
                            <div class="input-field col s12 browser-default">
                              <input id="email" type="email" class="validate">
                              <label for="email">{{ trans('welcome.enteremail') }}</label>
                              <small class="grey-text text-darken-2">{{ trans('welcome.nospam') }}</small>
                            </div>
                            <div class="input-field sosmed col s12">
                              <a href="#"><i class="fa fa-instagram fa-3x"></i></a>
                              <a href="https://web.facebook.com/KolosID"><i class="fa fa-facebook-official fa-3x"></i></a>
                            </div>
                          </div>
                      </form>
                  </div>
              </div>
              <div class="row">
                  <div class="col m12 center copyright">
                        <a href="{{ url('/page/term-of-use') }}" class="modal-trigger">Term of Services</a> <a href="{{ url('/page/privacy') }}">Privacy Policy</a>
                        <p>Copyright © 2016 Kolos Services Indonesia, PT . All Rights Reserved.</p>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- <div id="modal1" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4>Header</h4>
      <p>A bunch of text</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
    </div>
  </div> -->

  <!-- <div id="formulir" class="modal">
    <div class="modal-content">
        <div class="col s12">
          <h4 class="header">{{ trans('welcome.becomeamerchant') }}</h4>
        </div>
        <form id="form-form" class="col s12" method="post" enctype="multipart/form-data" action="{{ url('submit/form/merchant') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row">
            <div class="input-field col s12">
              <input name="business_name" type="text" class="validate">
              <label>{{ trans('welcome.BusinessName') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="col s12">
              <label>{{ trans('welcome.ServiceCategory') }}</label>
              <div class="input-field">
                <select name="category" required>
                  <option value="">{{ trans('welcome.ChooseCategory') }}</option>
                  <optgroup label="{{ trans('welcome.Health&Beauty') }}">
                    <option value="Massage & therapy">{{ trans('welcome.Massage&Therapy') }}</option>
                    <option value="Sport & fitness">{{ trans('welcome.Sport&Fitness') }}</option>
                    <option value="Beauty">{{ trans('welcome.Beauty') }}</option>
                    <option value="Fashion">{{ trans('welcome.Fashion') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Home') }}">
                    <option value="Laundry">{{ trans('welcome.Laundry') }}</option>
                    <option value="Electrician">{{ trans('welcome.Electrician') }}</option>
                    <option value="Plumber">{{ trans('welcome.Plumber') }}</option>
                    <option value="Movers">{{ trans('welcome.Movers') }}</option>
                    <option value="Gardener">{{ trans('welcome.Gardeners') }}</option>
                    <option value="Maid">{{ trans('welcome.Maid') }}</option>
                    <option value="Baby Sitter">{{ trans('welcome.BabySitter') }}</option>
                    <option value="Security">{{ trans('welcome.Security') }}</option>
                    <option value="Daily Butler">{{ trans('welcome.DailyButler') }}</option>
                    <option value="Painter">{{ trans('welcome.Painter') }}</option>
                    <option value="Pest Control">{{ trans('welcome.PestControl') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Repair') }}">
                    <option value="Electronic">{{ trans('welcome.Electronic') }}</option>
                    <option value="Mechanic">{{ trans('welcome.Mechanic') }}</option>
                    <option value="Home Appliance">{{ trans('welcome.HomeAppliance') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Transport') }}">
                    <option value="Courier">{{ trans('welcome.Courier') }}</option>
                    <option value="Driver">{{ trans('welcome.Driver') }}</option>
                    <option value="Car Rental">{{ trans('welcome.CarRental') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Event&Entertainment') }}">
                    <option value="DJ & band">{{ trans('welcome.DJ&Band') }}</option>
                    <option value="Event Organizer">{{ trans('welcome.EO') }}</option>
                    <option value="Wedding Organizer">{{ trans('welcome.WO') }}</option>
                    <option value="MC & Host">{{ trans('welcome.MC&Host') }}</option>
                    <option value="Sales Promotion Girls">{{ trans('welcome.SPG') }}</option>
                    <option value="Catering">{{ trans('welcome.Catering') }}</option>
                    <option value="Chef">{{ trans('welcome.Chef') }}</option>
                    <option value="Flower Delivery">{{ trans('welcome.FlowerDelivery') }}</option>
                    <option value="Tarot Reading">{{ trans('welcome.TarotReading') }}</option>
                    <option value="Palm Reading">{{ trans('welcome.PalmReading') }}</option>
                    <option value="Portrait Artistery">{{ trans('welcome.PortraitArtistry') }}</option>
                    <option value="Photo video">{{ trans('welcome.PhotoVideo') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Lesson&Edication') }}">
                    <option value="Academic lesson">{{ trans('welcome.AcademicLesson') }}</option>
                    <option value="Art, craft & design">{{ trans('welcome.ArtCraftDesign') }}</option>
                    <option value="Performance">{{ trans('welcome.Performance') }}</option>
                    <option value="Recreational">{{ trans('welcome.Recreational') }}</option>
                  </optgroup>
                  <optgroup label="{{ trans('welcome.Business&Legal') }}">
                    <option value="Translation">{{ trans('welcome.Translation') }}</option>
                    <option value="Writer">{{ trans('welcome.Writer') }}</option>
                    <option value="Lawyer">{{ trans('welcome.Lawyer') }}</option>
                    <option value="Notary">{{ trans('welcome.Notary') }}</option>
                    <option value="Agents">{{ trans('welcome.Agent') }}</option>
                    <option value="Accountant">{{ trans('welcome.Accountant') }}</option>
                    <option value="Bodyguard">{{ trans('welcome.Bodyguard') }}</option>
                    <option value="Programmer">{{ trans('welcome.Programmer') }}</option>
                    <option value="Designer">{{ trans('welcome.Designer') }}</option>
                  </optgroup>
                  <optgroup label="+">
                    <option value="Other">{{ trans('welcome.Other') }}</option>
                  </optgroup>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="business_address" type="text" class="validate">
              <label>{{ trans('welcome.Business Address') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="business_phone" type="text" class="validate">
              <label>{{ trans('welcome.Business Phone Number') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="name" type="text" class="validate">
              <label>{{ trans('welcome.Name of Person in Charge') }}</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input name="phone" type="text" class="validate">
              <label>{{ trans('welcome.Phone Number of Person in Charge') }}</label>
            </div>
            <div class="input-field col s6">
              <input name="email" type="email" class="validate">
              <label>Email</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea name="description" class="materialize-textarea"></textarea>
              <label>{{ trans('welcome.Business Description') }}</label>
            </div>
          </div>


          <div class="row">
            <div class="file-field input-field col s12">
              <div class="btn">
                <span>{{ trans('welcome.Profile Picture') }}</span>
                <input id="file" name="profile_picture" type="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="{{ trans('welcome.Upload Profile Picture') }}">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <label>{{ trans('welcome.Opening Time') }}</label>
              <div class="input-field">
                <input name="open_time" type="time">
              </div>
            </div>
            <div class="col s6">
              <label>{{ trans('welcome.Closing Time') }}</label>
              <div class="input-field">
                <input name="close_time" type="time" placeholder="00:00">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input name="area_covered" type="text" class="validate">
              <label>{{ trans('welcome.Area Covered') }}</label>
            </div>
            <div class="input-field col s6">
              <input name="number_employees" type="number" class="validate">
              <label>{{ trans('welcome.Number of Employees') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <div class="input_fields_wrap row">

                  <label>{{ trans('welcome.List of Services') }}</label>
                  <input class="col s11" type="text" name="service[]">
                  <a href="#" class="add_field_button"><i class="material-icons">add_circle_outline</i></a>

              </div>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s6">
              <input name="email_registration" type="email" class="validate">
              <label>{{ trans('welcome.Email of Registration') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s6">
              <input name="username" type="text" class="validate">
              <label>{{ trans('welcome.Username') }}</label>
            </div>
            <div class="input-field col s6">
              <input name="password" type="password" class="validate">
              <label>{{ trans('welcome.Password') }}</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input name="mobile" type="text" class="validate">
              <label>{{ trans('welcome.Type of mobile phone used') }}</label>
            </div>
          </div>
        </form>

    </div>
    <div class="modal-footer">
      <div class="col s12">
        <a href="#!" id="submit-form" class="waves-effect waves-green btn-flat">{{ trans('welcome.Submit') }}</a>
      </div>
    </div>
  </div> -->

@stop
