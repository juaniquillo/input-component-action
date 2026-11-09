<?php

declare(strict_types=1);

namespace Tests\Support;

use Juaniquillo\BackendComponents\Contracts\BackendComponent;
use Juaniquillo\BackendComponents\Contracts\ContentComponent;
use Juaniquillo\BackendComponents\Contracts\ThemeComponent;

final class ComponentTree
{
    /**
     * A stable, path-independent view of a component tree.
     *
     * @return array{
     *     type: int|string|null,
     *     attributes: array<string, int|string|null>,
     *     themes: array<string, mixed>,
     *     contents: array<int|string, mixed>
     * }
     */
    public static function of(BackendComponent $component): array
    {
        $tree = [
            'type' => method_exists($component, 'getName') ? $component->getName() : null,
            'attributes' => $component->getAttributes(),
            'themes' => $component instanceof ThemeComponent ? $component->getThemes() : [],
            'contents' => [],
        ];

        if ($component instanceof ContentComponent) {
            foreach ($component->getContents() as $key => $content) {
                $tree['contents'][$key] = $content instanceof BackendComponent
                    ? self::of($content)
                    : $content;
            }
        }

        return $tree;
    }

    /**
     * @return array<int|string, mixed>
     */
    public static function contentsOf(BackendComponent $component): array
    {
        if (! $component instanceof ContentComponent) {
            return [];
        }

        return array_map(
            static fn (mixed $content): mixed => $content instanceof BackendComponent
                ? self::of($content)
                : $content,
            $component->getContents(),
        );
    }

    /**
     * @return array<int|string, mixed>
     */
    public static function typesOf(BackendComponent $component): array
    {
        return array_map(
            static fn (mixed $content): mixed => $content instanceof BackendComponent
                ? (method_exists($content, 'getName') ? $content->getName() : null)
                : $content,
            self::rawContents($component),
        );
    }

    /**
     * @return array<int|string, mixed>
     */
    public static function rawContents(BackendComponent $component): array
    {
        return $component instanceof ContentComponent ? $component->getContents() : [];
    }

    public static function find(BackendComponent $component, string $type): ?BackendComponent
    {
        if (method_exists($component, 'getName') && $component->getName() === $type) {
            return $component;
        }

        foreach (self::rawContents($component) as $content) {
            if (! $content instanceof BackendComponent) {
                continue;
            }

            $found = self::find($content, $type);

            if ($found) {
                return $found;
            }
        }

        return null;
    }

    /**
     * @return array<int, BackendComponent>
     */
    public static function findAll(BackendComponent $component, string $type): array
    {
        $found = [];

        if (method_exists($component, 'getName') && $component->getName() === $type) {
            $found[] = $component;
        }

        foreach (self::rawContents($component) as $content) {
            if (! $content instanceof BackendComponent) {
                continue;
            }

            $found = [...$found, ...self::findAll($content, $type)];
        }

        return $found;
    }
}
