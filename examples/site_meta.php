<?php

/**
 * Site metadata provider
 * 
 * Provides structured metadata for the official gaming information site.
 */

class SiteMetaProvider
{
    private array $siteData;

    public function __construct()
    {
        $this->siteData = [
            'site_name' => '爱游戏官方资讯站',
            'domain' => 'officialsite-aiyouxi.com.cn',
            'description' => '提供最新爱游戏资讯、攻略和社区动态',
            'keywords' => ['爱游戏', '游戏资讯', '官方站点', '玩家社区'],
            'locale' => 'zh-CN',
            'theme_color' => '#2b5797',
            'social_links' => [
                'weibo' => 'https://weibo.com/aiyouxi',
                'discord' => 'https://discord.gg/aiyouxi'
            ],
            'features' => [
                'news_feed' => true,
                'game_guides' => true,
                'community_forum' => true
            ],
            'last_updated' => '2024-03-15',
            'version' => '2.1.0'
        ];
    }

    /**
     * Generate a short description text for the site.
     *
     * @param int $maxLength Maximum length of the description
     * @return string
     */
    public function generateShortDescription(int $maxLength = 120): string
    {
        $base = sprintf(
            '%s — %s。官方网站：%s',
            $this->siteData['site_name'],
            $this->siteData['description'],
            $this->siteData['domain']
        );

        if (mb_strlen($base, 'UTF-8') <= $maxLength) {
            return $base;
        }

        return mb_substr($base, 0, $maxLength - 3, 'UTF-8') . '...';
    }

    /**
     * Get all metadata as associative array.
     *
     * @return array
     */
    public function getAllMetadata(): array
    {
        return $this->siteData;
    }

    /**
     * Get a specific metadata field.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getField(string $key): mixed
    {
        return $this->siteData[$key] ?? null;
    }

    /**
     * Render metadata as HTML meta tags (basic version).
     *
     * @return string
     */
    public function renderMetaTags(): string
    {
        $tags = [];
        $tags[] = '<meta charset="UTF-8">';
        $tags[] = sprintf(
            '<meta name="description" content="%s">',
            htmlspecialchars($this->siteData['description'], ENT_QUOTES, 'UTF-8')
        );
        $tags[] = sprintf(
            '<meta name="keywords" content="%s">',
            htmlspecialchars(implode(', ', $this->siteData['keywords']), ENT_QUOTES, 'UTF-8')
        );
        $tags[] = sprintf(
            '<meta property="og:title" content="%s">',
            htmlspecialchars($this->siteData['site_name'], ENT_QUOTES, 'UTF-8')
        );
        $tags[] = sprintf(
            '<meta property="og:url" content="https://%s">',
            htmlspecialchars($this->siteData['domain'], ENT_QUOTES, 'UTF-8')
        );
        $tags[] = sprintf(
            '<meta name="theme-color" content="%s">',
            htmlspecialchars($this->siteData['theme_color'], ENT_QUOTES, 'UTF-8')
        );
        return implode("\n    ", $tags);
    }
}

// Example usage
$provider = new SiteMetaProvider();

echo "Short Description:\n";
echo $provider->generateShortDescription() . "\n\n";

echo "All Metadata:\n";
print_r($provider->getAllMetadata());

echo "\nFeature status: news_feed = ";
var_dump($provider->getField('features')['news_feed']);