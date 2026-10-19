<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SeoPerformanceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Kiểm tra Trang chủ chuẩn SEO on-page: Thẻ meta, Open Graph, duy nhất 1 thẻ h1, Schema AutoDealer & Preload LCP
     */
    public function test_homepage_has_seo_elements_and_single_h1(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $content = $response->getContent();

        // 1. Thẻ ngôn ngữ lang="vi" và viewport
        $this->assertStringContainsString('lang="vi"', $content);
        $this->assertStringContainsString('name="viewport"', $content);

        // 2. Thẻ Meta Description & Canonical
        $this->assertStringContainsString('name="description"', $content);
        $this->assertStringContainsString('rel="canonical"', $content);

        // 3. Resource Hints & LCP Preload
        $this->assertStringContainsString('rel="preconnect"', $content);
        $this->assertStringContainsString('rel="preload" as="image"', $content);

        // 4. Open Graph & Twitter Cards
        $this->assertStringContainsString('property="og:title"', $content);
        $this->assertStringContainsString('property="og:type"', $content);
        $this->assertStringContainsString('name="twitter:card"', $content);

        // 5. Structured Data JSON-LD Schema (AutoDealer)
        $this->assertStringContainsString('"@type": "AutoDealer"', $content);
        $this->assertStringContainsString('"name": "PrimeLux Auto"', $content);

        // 6. Quy chuẩn Slide 23 & 29: Duy nhất 1 thẻ h1 trên toàn trang
        preg_match_all('/<h1\b[^>]*>/i', $content, $h1Matches);
        $this->assertCount(1, $h1Matches[0], 'Trang chủ chỉ được phép có duy nhất 1 thẻ <h1> theo quy chuẩn SEO Chương 8');
    }

    /**
     * Kiểm tra trang Chi tiết xe có đầy đủ Product JSON-LD, Open Graph và Heading chuẩn
     */
    public function test_car_detail_page_has_product_schema_and_meta(): void
    {
        $response = $this->get('/cars/car-01');
        $response->assertStatus(200);

        $content = $response->getContent();

        // 1. Meta Description cho sản phẩm
        $this->assertStringContainsString('name="description"', $content);

        // 2. Schema Product / Car
        $this->assertStringContainsString('"@type": "Product"', $content);
        $this->assertStringContainsString('"@type": "Brand"', $content);

        // 3. Duy nhất 1 thẻ h1 trên trang chi tiết xe
        preg_match_all('/<h1\b[^>]*>/i', $content, $h1Matches);
        $this->assertCount(1, $h1Matches[0], 'Trang chi tiết xe chỉ được phép có duy nhất 1 thẻ <h1>');

        // 4. Kiểm tra có thẻ h2 (không nhảy cóc h1 -> h3)
        $this->assertStringContainsString('<h2', $content, 'Trang chi tiết xe phải có thẻ <h2> để đảm bảo thứ tự phân cấp heading');
    }

    /**
     * Kiểm tra tệp robots.txt chuẩn cấu trúc theo Chương 8
     */
    public function test_robots_txt_exists_and_configured_properly(): void
    {
        $robotsPath = public_path('robots.txt');
        $this->assertFileExists($robotsPath);

        $content = file_get_contents($robotsPath);
        $this->assertStringContainsString('User-agent: *', $content);
        $this->assertStringContainsString('Disallow: /admin/', $content);
        $this->assertStringContainsString('Disallow: /api/', $content);
        $this->assertStringContainsString('Sitemap:', $content);
    }

    /**
     * Kiểm tra tệp sitemap.xml hợp lệ
     */
    public function test_sitemap_xml_returns_valid_xml(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));

        $content = $response->getContent();
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString('<loc>', $content);
        $this->assertStringContainsString('cars/car-01', $content);
    }
}
