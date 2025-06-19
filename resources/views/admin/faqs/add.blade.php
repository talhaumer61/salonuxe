<header class="page-header page-header-left-inline-breadcrumb">
    <h2 class="font-weight-bold text-6">FAQ's</h2>
    <div class="right-wrapper">
        <ol class="breadcrumbs">
            <li><span>Dashboard</span></li>
            <li><span>FAQ's</span></li>
            <li><span>Add</span></li>
        </ol>
    </div>
</header>
<!-- start: page -->
<form class="ecommerce-form action-buttons-fixed" action="{{ route('faqs.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-2-5 col-xl-1-5">
                            <i class="card-big-info-icon bx bx-slider"></i>
                            <h2 class="card-big-info-title">Details</h2>
                            <p class="card-big-info-desc">Add description with all details and necessary information.</p>
                        </div>
                        <div class="col-lg-3-5 col-xl-4-5">
                            <div class="form-group row align-items-center mb-3">
                                <label class="col-lg-2 col-xl-2 control-label text-lg-end mb-0">Question</label>
                                <div class="col-lg-10 col-xl-10">
                                    <input type="text" class="form-control form-control-modern" name="question" value="" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-xl-2 control-label text-lg-end pt-2 mt-1 mb-0">Answer</label>
                                <div class="col-lg-10 col-xl-10">
                                    <textarea class="form-control form-control-modern" name="answer" id="ckeditor" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="form-group row align-items-center pb-3">
                                <label class="col-lg-2 col-xl-2 control-label text-lg-end mb-0">Status</label>
                                <div class="col-lg-10 col-xl-10">
                                    <select class="form-control form-control-modern" name="status">
                                        <option value="in-stock" selected="">Choose One...</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row action-buttons">
        <div class="col-12 col-md-auto ms-md-auto mt-3 mt-md-0 ms-auto d-flex">
            <a href="/faqs" class="mx-1 btn btn-danger btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                Cancel
            </a>
            <button href="#" class="mx-1 btn btn-primary btn-px-4 py-3 d-flex align-items-center font-weight-semibold line-height-1">
                <i class="bx bx-save text-4 me-2"></i> Add
            </button>
        </div>
    </div>
</form>