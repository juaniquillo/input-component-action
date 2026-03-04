<?php declare(strict_types = 1);

// osfsl-C:/Users/juani/Code/packages/input-component-action/vendor/composer/../juaniquillo/laravel-backend-component/src/MainBackendComponent.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Juaniquillo\BackendComponents\MainBackendComponent
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-57cf0b8d02fd8077a3b4f28d72b0e8720c745d18f09d29e07166727968f769da-8.4.16-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'filename' => 'C:/Users/juani/Code/packages/input-component-action/vendor/composer/../juaniquillo/laravel-backend-component/src/MainBackendComponent.php',
      ),
    ),
    'namespace' => 'Juaniquillo\\BackendComponents',
    'name' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
    'shortName' => 'MainBackendComponent',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 23,
    'endLine' => 114,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
      0 => 'Juaniquillo\\BackendComponents\\Contracts\\CompoundComponent',
      1 => 'Illuminate\\Contracts\\Support\\Htmlable',
    ),
    'traitClassNames' => 
    array (
      0 => 'Juaniquillo\\BackendComponents\\Concerns\\HasContent',
      1 => 'Juaniquillo\\BackendComponents\\Concerns\\HasPath',
      2 => 'Juaniquillo\\BackendComponents\\Concerns\\HasSettings',
      3 => 'Juaniquillo\\BackendComponents\\Concerns\\HasSlots',
      4 => 'Juaniquillo\\BackendComponents\\Concerns\\IsBackendComponent',
      5 => 'Juaniquillo\\BackendComponents\\Concerns\\IsLivewireComponent',
      6 => 'Juaniquillo\\BackendComponents\\Concerns\\IsThemeable',
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'name' => 
      array (
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'name' => 'name',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
          'data' => 
          array (
            'types' => 
            array (
              0 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'string',
                  'isIdentifier' => true,
                ),
              ),
              1 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'BackedEnum',
                  'isIdentifier' => false,
                ),
              ),
            ),
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 34,
        'endLine' => 34,
        'startColumn' => 9,
        'endColumn' => 39,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'themeManager' => 
      array (
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'name' => 'themeManager',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeManager',
            'isIdentifier' => false,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 35,
        'endLine' => 35,
        'startColumn' => 9,
        'endColumn' => 68,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionUnionType',
              'data' => 
              array (
                'types' => 
                array (
                  0 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'string',
                      'isIdentifier' => true,
                    ),
                  ),
                  1 => 
                  array (
                    'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                    'data' => 
                    array (
                      'name' => 'BackedEnum',
                      'isIdentifier' => false,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 34,
            'endLine' => 34,
            'startColumn' => 9,
            'endColumn' => 39,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'themeManager' => 
          array (
            'name' => 'themeManager',
            'default' => 
            array (
              'code' => 'new \\Juaniquillo\\BackendComponents\\Themes\\DefaultThemeManager()',
              'attributes' => 
              array (
                'startLine' => 35,
                'endLine' => 35,
                'startTokenPos' => 152,
                'startFilePos' => 1251,
                'endTokenPos' => 154,
                'endFilePos' => 1273,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeManager',
                'isIdentifier' => false,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 35,
            'endLine' => 35,
            'startColumn' => 9,
            'endColumn' => 68,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 33,
        'endLine' => 36,
        'startColumn' => 5,
        'endColumn' => 8,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'aliasName' => NULL,
      ),
      'getAttributeBag' => 
      array (
        'name' => 'getAttributeBag',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Juaniquillo\\BackendComponents\\Contracts\\AttributeBag',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 38,
        'endLine' => 51,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'aliasName' => NULL,
      ),
      'toArray' => 
      array (
        'name' => 'toArray',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @return array{
 *  name:  int|string,
 *  component: class-string<BackendComponent|CompoundComponent>,
 *  attributes: array<string, int|string|null>,
 *  contents: array<string,array<string, int|string>|int|string>,
 *  theme: array{
 *   manager: class-string<ThemeManager>,
 *   themes: array<string, array<int|string, string>|string>,
 *   path: string,
 *   realPath: string,
 *  },
 *  path: string|null,
 *  slots: array<string, array<string, int|string>|int|string>,
 *  settings: array<string, bool|string>,
 *  isLivewire: bool,
 *  livewireKey: string|null,
 *  livewireParams: array<string, mixed>
 * }
 */',
        'startLine' => 73,
        'endLine' => 93,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'aliasName' => NULL,
      ),
      'toHtml' => 
      array (
        'name' => 'toHtml',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Get content as a string of HTML.
 *
 * @return string
 */',
        'startLine' => 100,
        'endLine' => 113,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\MainBackendComponent',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));