<?php

namespace App\Http\Controllers;

use App\Models\NhatKyChat;
use App\Models\KhachHang;
use Illuminate\Http\Request;

class TuVanVienController extends Controller
{
    /**
     * Hiển thị trang cổng chuyên viên tư vấn (Vietnamese wrapper)
     */
    public function index(Request $request)
    {
        // Delegate to ConsultantController's full logic
        $consultantController = new ConsultantController();
        return $consultantController->index($request);
    }

    public function reply(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->reply($request);
    }

    public function updateStatus(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->updateStatus($request);
    }

    public function submitQuestion(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->submitQuestion($request);
    }

    public function checkReply(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->checkReply($request);
    }

    public function getRealtimeFeed(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->getRealtimeFeed($request);
    }

    public function sseStream(Request $request)
    {
        $consultantController = new ConsultantController();
        return $consultantController->sseStream($request);
    }
}
