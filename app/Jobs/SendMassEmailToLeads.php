<?php

// namespace App\Jobs;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\Dispatchable;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;
// use App\Models\Lead;
// use Illuminate\Support\Facades\Mail;

// class SendMassEmailToLeads implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     protected $leadIds;

//     public function __construct(array $leadIds)
//     {
//         $this->leadIds = $leadIds;
//     }

//     public function handle()
//     {
//         $leads = Lead::whereIn('id', $this->leadIds)->get();

//         foreach ($leads as $lead) {
//             if ($lead->email) {
//                 Mail::to($lead->email)->send(new \App\Mail\LeadPromoMail($lead));
//             }
//         }
//     }
// }

