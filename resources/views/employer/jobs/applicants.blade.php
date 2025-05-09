@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4 p-3">
                    <h3 class="fs-4 mb-4">Applicants for: {{ $job->title }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Applied Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applicants as $applicant)
                                    <tr>
                                        <td>{{ $applicant->user->name ?? 'N/A' }}</td>
                                        <td>{{ $applicant->user->email ?? 'N/A' }}</td>
                                        <td>{{ $applicant->applied_date ? \Carbon\Carbon::parse($applicant->applied_date)->format('d M, Y') : 'N/A' }}</td>
                                        <td>
                                            {{-- Add more actions if needed, e.g., view application details --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No applicants found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $applicants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 