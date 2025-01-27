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
                    <img src="dashboard/img/!logged-user.jpg" class="rounded img-fluid" alt="John Doe">
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner">John Doe</span>
                        <span class="thumb-info-type">CEO</span>
                    </div>
                </div>
                <div class="widget-toggle-expand mb-3">
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
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-8 col-xl-9 mb-4 mb-xl-0">
        <div class="tabs mb-0">
            <ul class="nav nav-tabs tabs-primary" role="tablist">
                
                <li class="nav-item active" role="presentation">
                    <button class="nav-link active" data-bs-target="#overview" data-bs-toggle="tab" aria-selected="true" role="tab">Overview</button>
                </li>
            </ul>
            <div class="tab-content">
                <div id="overview" class="tab-pane active show" role="tabpanel">
                    <form class="p-3">
                        <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                        <div class="row row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress">Address</label>
                                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="form-group col">
                                <label for="inputAddress2">Address 2</label>
                                <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-4 border-top-0 pt-0">
                                <label for="inputState">State</label>
                                <select id="inputState" class="form-control">
                                    <option selected="">Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 border-top-0 pt-0">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <hr class="dotted tall">
                        <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">New Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                            <div class="form-group col-md-6 border-top-0 pt-0">
                                <label for="inputPassword5">Re New Password</label>
                                <input type="password" class="form-control" id="inputPassword5" placeholder="Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end mt-3">
                                <button class="btn btn-primary modal-confirm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>