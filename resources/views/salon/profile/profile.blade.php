<header class="page-header">
    <h2>User Profile</h2>
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs pe-2">
            <li>
                <a href="/">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li>
            <li><span>Profile</span></li>
            <li><span>User Profile</span></li>
        </ol>
    </div>
</header>
<div class="row">
    <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
        <section class="card h-100 ">
            <div class="card-body">
                <div class="thumb-info mb-3">
                    <img src="{{(''.session('user')->photo.'')}}" class="rounded img-fluid" alt="John Doe">
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner">{{session('user')->name}}</span>
                        {{-- <span class="thumb-info-type">CEO</span> --}}
                    </div>
                </div>
                {{-- <div class="widget-toggle-expand mb-3">
                    <div class="widget-header">
                        <h5 class="mb-2 font-weight-semibold text-dark">Profile Completion</h5>
                        <div class="widget-toggle">+</div>
                    </div>
                    <div class="widget-content-collapsed">
                        <div class="progress progress-xs light">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                60%
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="dotted short">
                <h5 class="mb-2 mt-3">About</h5>
                <p class="text-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis vulputate quam. Interdum et malesuada</p>
                <hr class="dotted short">
                <div class="social-icons-list">
                    <a rel="tooltip" data-bs-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
                    <a rel="tooltip" data-bs-placement="bottom" href="http://www.twitter.com" data-original-title="Twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                    <a rel="tooltip" data-bs-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
                </div> --}}
            </div>
        </section>
    </div>
    <div class="col-lg-8 col-xl-9 mb-4 mb-xl-0">
        <div class="tabs mb-0">
            <ul class="nav nav-tabs tabs-primary" role="tablist">
                
                <li class="nav-item active" role="presentation">
                    <button class="nav-link text-dark {{ session('activeTab') === 'overview' ? 'active' : '' }}" data-bs-target="#overview" data-bs-toggle="tab" aria-selected="true" role="tab" id="overview-tab">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark {{ session('activeTab') === 'password' ? 'active' : '' }}" data-bs-target="#password" data-bs-toggle="tab" aria-selected="true" role="tab" id="password-tab">Password</button>
                </li>                
            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane {{ session('activeTab') === 'overview' ? 'active show' : '' }}" role="tabpanel">
                    <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputName">Name</label>
                                <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name', session('user')->name) }}">
                            </div>
                            <div class="form-group col-md-6 pt-0">
                                <label for="inputUsername">Username</label>
                                <input type="text" class="form-control" id="inputUsername" name="username" value="{{ old('username', session('user')->username) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="inputEmail" name="email" value="{{ old('email', session('user')->email) }}" readonly>
                            </div>
                            <div class="form-group col-md-6 pt-0">
                                <label for="inputPhone">Phone</label>
                                <input type="text" class="form-control" id="inputPhone" name="phone" value="{{ old('phone', session('user')->phone) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="inputPhoto">Profile Photo</label>
                                <input type="file" class="form-control" id="inputPhoto" name="photo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button class="btn btn-primary">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="password" class="tab-pane {{ session('activeTab') === 'password' ? 'active show' : '' }}" role="tabpanel">
                    <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                    <form action="{{ route('change.password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <!-- Display error for current password -->
                                @if ($errors->has('current_password'))
                                    <div class="text-danger mt-2">{{ $errors->first('current_password') }}</div>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                @if ($errors->has('new_password'))
                                    <div class="text-danger mt-2">{{ $errors->first('new_password') }}</div>
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>