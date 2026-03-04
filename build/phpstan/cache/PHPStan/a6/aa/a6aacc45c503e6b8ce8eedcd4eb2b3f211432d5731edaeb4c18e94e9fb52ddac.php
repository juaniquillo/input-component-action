<?php declare(strict_types = 1);

// osfsl-C:/Users/juani/Code/packages/input-component-action/vendor/composer/../juaniquillo/laravel-backend-component/src/Contracts/ThemeComponent.php-PHPStan\BetterReflection\Reflection\ReflectionClass-Juaniquillo\BackendComponents\Contracts\ThemeComponent
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-81159873229731b7f3da8fd39a064228385024c44ef5a99354cfc2184f1998a1-8.4.16-6.65.0.9',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'filename' => 'C:/Users/juani/Code/packages/input-component-action/vendor/composer/../juaniquillo/laravel-backend-component/src/Contracts/ThemeComponent.php',
      ),
    ),
    'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
    'name' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
    'shortName' => 'ThemeComponent',
    'isInterface' => true,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 0,
    'docComment' => NULL,
    'attributes' => 
    array (
    ),
    'startLine' => 7,
    'endLine' => 34,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
    ),
    'immediateMethods' => 
    array (
      'setThemeManager' => 
      array (
        'name' => 'setThemeManager',
        'parameters' => 
        array (
          'themeManager' => 
          array (
            'name' => 'themeManager',
            'default' => NULL,
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
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 9,
            'endLine' => 9,
            'startColumn' => 37,
            'endColumn' => 62,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'static',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 9,
        'endLine' => 9,
        'startColumn' => 5,
        'endColumn' => 72,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'setTheme' => 
      array (
        'name' => 'setTheme',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 14,
            'endLine' => 14,
            'startColumn' => 30,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'theme' => 
          array (
            'name' => 'theme',
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
                      'name' => 'array',
                      'isIdentifier' => true,
                    ),
                  ),
                ),
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 14,
            'endLine' => 14,
            'startColumn' => 44,
            'endColumn' => 62,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'static',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param  string|array<string|int, string>  $theme
 */',
        'startLine' => 14,
        'endLine' => 14,
        'startColumn' => 5,
        'endColumn' => 72,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'setThemes' => 
      array (
        'name' => 'setThemes',
        'parameters' => 
        array (
          'themes' => 
          array (
            'name' => 'themes',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 19,
            'endLine' => 19,
            'startColumn' => 31,
            'endColumn' => 43,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'static',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param  array<string, string|array<string|int, string>>  $themes
 */',
        'startLine' => 19,
        'endLine' => 19,
        'startColumn' => 5,
        'endColumn' => 53,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'getThemes' => 
      array (
        'name' => 'getThemes',
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
 * @return array<string, string|array<string|int, string>>
 */',
        'startLine' => 24,
        'endLine' => 24,
        'startColumn' => 5,
        'endColumn' => 39,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'getTheme' => 
      array (
        'name' => 'getTheme',
        'parameters' => 
        array (
          'name' => 
          array (
            'name' => 'name',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 29,
            'endLine' => 29,
            'startColumn' => 30,
            'endColumn' => 41,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
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
                  'name' => 'array',
                  'isIdentifier' => true,
                ),
              ),
              2 => 
              array (
                'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
                'data' => 
                array (
                  'name' => 'null',
                  'isIdentifier' => true,
                ),
              ),
            ),
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @return string|array<string|int, string>|null
 */',
        'startLine' => 29,
        'endLine' => 29,
        'startColumn' => 5,
        'endColumn' => 62,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'getThemeManager' => 
      array (
        'name' => 'getThemeManager',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeManager',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 31,
        'endLine' => 31,
        'startColumn' => 5,
        'endColumn' => 52,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'aliasName' => NULL,
      ),
      'compileTheme' => 
      array (
        'name' => 'compileTheme',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
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
                  'name' => 'null',
                  'isIdentifier' => true,
                ),
              ),
            ),
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 33,
        'endLine' => 33,
        'startColumn' => 5,
        'endColumn' => 44,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'Juaniquillo\\BackendComponents\\Contracts',
        'declaringClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'implementingClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
        'currentClassName' => 'Juaniquillo\\BackendComponents\\Contracts\\ThemeComponent',
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