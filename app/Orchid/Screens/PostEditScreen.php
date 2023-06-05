<?php

namespace App\Orchid\Screens;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class PostEditScreen extends Screen
{
    public $post;

    public function query(Post $post): array
    {
        return [
            'post' => $post
        ];
    }

    public function name(): ?string
    {
        return $this->post->exists ? 'Edit post' : 'Creating a new post';
    }

    public function commandBar(): array
    {
        return [
            Button::make('Create post')
                // ->icon('plus')
                ->method('createOrUpdate')
                ->canSee(!$this->post->exists),

            Button::make('Update')
                ->icon('pencil-square')
                ->method('createOrUpdate')
                ->canSee($this->post->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->post->exists)
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $request->validate([
            'post.title' => 'required|max:255',
            'post.description' => 'required',
            'post.body' => 'required',
            'post.author' => 'required',
        ]);
        $post = new Post();
        $post->fill($request->get('post'))->save();
        Alert::info('You have successfully created a post.');
        return redirect()->route('platform.post.list');
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('post.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this post.'),
                TextArea::make('post.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),
                Relation::make('post.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),
                Quill::make('post.body')
                    ->title('Main text'),
            ])
        ];
    }

    public function remove(Post $post)
    {
        $post->delete();
        Alert::info('You have successfully deleted the post.');
        return redirect()->route('platform.post.list');
    }
}
