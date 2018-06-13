<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/17/18
 * Time: 1:04 PM
 */

namespace App\Models\ViewModels;

use Carbon\Carbon;

class ArticleEnriched
{
    public $id;
    public $parent_article_id;
    public $status_id;
    public $title;
    public $body;
    public $excerpt;
    public $body_image;
    public $thumbnail_image;
    public $last_edited_by_user_id;
    public $cms_id;
    public $cms_name;
    public $cms;
    public $is_sticky;
    public $created_text;
    public $updated_at;
    public $categories = '';
    public $author_name;
    public $author_email;
    public $original_creator;
    public $status_label;
    public $could_be_published;
    public $is_published;
    public $publish_button_text;

    public $publicUrl;
    public $previewUrl;
    public $is_purchased;
    public $is_available_for_purchase;

    public function __construct($article)
    {
        $this->id = $article->id;
        $this->parent_article_id = $article->parent_article_id;
        $this->status_id = $article->status_id;
        $this->title = $article->title;
        $this->body = $article->body;
        $this->excerpt = $article->excerpt;
        $this->body_image = $article->body_image;
        $this->thumbnail_image = $article->thumbnail_image;
        $this->last_edited_by_user_id = ($article->editor) ? $article->editor->id : $article->parent->editor->id;
        $this->cms_id = $article->cms_id;
        if ($article->cms)
            $this->cms = $article->cms;

        $this->is_sticky = $article->is_sticky;
        $this->created_text = "Date created: " . Carbon::createFromFormat('Y-m-d H:i:s', $article->created_at)->format('d/m/Y H:i:s');
        $this->updated_at = $article->updated_at;
        $this->allCategories = $article->categories;
        $this->tags = $article->tags;
        $this->categories = $article->categories->count() === 0 ?
            '<span class="fa fa-warning"></span><span class="category-warning">No category selected</span>'
            : implode(', ', $article->categories->pluck('name')->toArray());
        $author = ($article->editor) ? $article->editor : $article->parent->editor;
        $this->author_name = $author->name . ' ' . $author->surname;
        $this->author_email = $author->email;
        $this->original_creator = $article->parent && $article->editor ? $article->parent->editor->name . ' ' . $article->parent->editor->surname : null;
        $this->status_label = $this->generateStatusLabel($article->status);
        // TODO: revisit this rule
        $this->could_be_published = $article->status->name !== 'Published' && $article->categories->count() > 0;
        $this->is_published = $article->status->name === 'Published';
        $this->publish_button_text = $this->could_be_published ? 'Publish the article' :
            ($article->categories->count() === 0 ? 'You need to set at least one category to publish the article' : '');

        $this->publicUrl = "";
        $this->previewUrl = "";
        if (!$article->categories->isEmpty()) {
            $articleCmsName = "news-central"; //by default all articles should be previews at news central (if they dont belong to a specific cms)
            if ($article->cms != null)
                $articleCmsName = $article->cms->system_name;

            $this->publicUrl = url("web") . "/" . $articleCmsName . "/" . $article->categories->first()->slug . "/article/" . $article->id;
            $this->previewUrl = $this->publicUrl . "/preview";
        }

        $this->is_purchased = !empty($article->purchasedFromStore);
        $this->is_available_for_purchase = !$article->storeInfo->isEmpty() ? $article->storeInfo->last()->status_id === 2 : false;
    }


    private function generateStatusLabel($status)
    {
        $className = 'label ';
        switch ($status->name) {
            case 'Published':
                $className .= "label-success";
                break;
            case 'Draft':
                $className .= "label-warning";
                break;
            case 'Unpublished':
            case 'Deleted':
                $className .= "label-danger";
                break;
            default:
                $className .= "label-primary";
        }
        return "<span class='$className'>$status->name</span>";
    }
}