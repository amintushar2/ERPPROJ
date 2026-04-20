<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserMenuPermissionController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('F_STORE.ALL_USER_INFO')
            ->select(
                DB::raw('TRIM(USER_ID)       AS user_id'),
                DB::raw('TRIM(EMPLOYEE_ID)   AS employee_id'),
                DB::raw('TRIM(USER_GROUP_ID) AS user_group_id'),
                DB::raw('TRIM(USER_ROLE)     AS user_role')
            )
            ->orderBy('USER_ID')
            ->get();

        $groups = DB::table('F_STORE.ALL_USER_GROUP_MASTER')
            ->select(DB::raw('TRIM(USER_GROUP_ID) AS user_group_id'))
            ->orderBy('USER_GROUP_ID')
            ->get();

        return view('admin.users.menu-permission', compact('users', 'groups'));
    }

    public function getMenus(Request $request, $userId)
    {
        $userId = trim((string) $userId);

        $menus = DB::table('F_STORE.ALL_MENU_HIERARCHY')
            ->select(
                DB::raw('TRIM(CHILD_ID)  AS child_id'),
                DB::raw('TRIM(TITLE)     AS title'),
                DB::raw('ITEM_TYPE       AS item_type'),
                DB::raw('TRIM(DIR)       AS dir'),
                DB::raw('SORT_BY         AS sort_by'),
                DB::raw('TRIM(PARENT_ID) AS parent_id'),
                DB::raw('TRIM(IS_ACTIVE) AS is_active')
            )
            ->orderBy('SORT_BY')
            ->get();

        $routeCounts = DB::table('F_STORE.ALL_ROUTE_DETAILS')
            ->select(
                DB::raw('TRIM(MENU_CHILD_ID) AS menu_child_id'),
                DB::raw('COUNT(*) AS total')
            )
            ->groupBy('MENU_CHILD_ID')
            ->get()
            ->keyBy('menu_child_id')
            ->map(fn($r) => (int) $r->total);

        $userInfo = DB::table('F_STORE.ALL_USER_INFO')
            ->whereRaw('TRIM(USER_ID) = ?', [$userId])
            ->select(DB::raw('TRIM(USER_GROUP_ID) AS user_group_id'))
            ->first();

        $groupId = $userInfo ? trim($userInfo->user_group_id) : '';

        $userMenuPerms = DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
            ->select(
                DB::raw('TRIM(MENU_ITEM_ID) AS menu_item_id'),
                DB::raw('TRIM(ENABLED)      AS enabled')
            )
            ->whereRaw('TRIM(USER_ID) = ?', [$userId])
            ->get()
            ->keyBy('menu_item_id')
            ->map(fn($r) => $r->enabled === 'Y');

        $hasUserOverrides = $userMenuPerms->isNotEmpty();

        $groupMenuPerms = DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
            ->select(
                DB::raw('TRIM(MENU_ITEM_ID) AS menu_item_id'),
                DB::raw('TRIM(ENABLED)      AS enabled')
            )
            ->whereRaw("TRIM(USER_GROUP_ID) = ?", [$groupId])
            ->whereRaw("(USER_ID IS NULL OR TRIM(USER_ID) = '')")
            ->get()
            ->keyBy('menu_item_id')
            ->map(fn($r) => $r->enabled === 'Y');

        $enabledRouteCounts = DB::table('F_STORE.ALL_USER_SUB_DETAILS')
            ->select(
                DB::raw('TRIM(MENU_ITEM_ID) AS menu_item_id'),
                DB::raw('COUNT(*) AS enabled_total')
            )
            ->whereRaw('TRIM(USER_ID) = ?', [$userId])
            ->whereRaw("TRIM(ENABLED) = 'Y'")
            ->groupBy('MENU_ITEM_ID')
            ->get()
            ->keyBy('menu_item_id')
            ->map(fn($r) => (int) $r->enabled_total);

        $result = $menus->map(function ($menu) use (
            $userMenuPerms, $groupMenuPerms, $hasUserOverrides,
            $routeCounts, $enabledRouteCounts
        ) {
            $mid = $menu->child_id;

            if ($hasUserOverrides) {
                $enabled = isset($userMenuPerms[$mid]) ? $userMenuPerms[$mid] : ($groupMenuPerms[$mid] ?? false);
                $source  = isset($userMenuPerms[$mid]) ? 'user' : 'group';
            } else {
                $enabled = $groupMenuPerms[$mid] ?? false;
                $source  = 'group';
            }

            return [
                'child_id'       => $mid,
                'title'          => $menu->title,
                'item_type'      => (int) $menu->item_type,
                'dir'            => $menu->dir,
                'sort_by'        => $menu->sort_by,
                'parent_id'      => $menu->parent_id,
                'is_active'      => $menu->is_active,
                'enabled'        => $enabled,
                'source'         => $source,
                'total_routes'   => $routeCounts[$mid] ?? 0,
                'enabled_routes' => $enabledRouteCounts[$mid] ?? 0,
            ];
        });

        return response()->json([
            'menus'    => $result,
            'group_id' => $groupId,
        ]);
    }

    public function getRoutes(Request $request, $userId, $menuId)
    {
        $userId = trim((string) $userId);
        $menuId = trim((string) $menuId);

        $routes = DB::table('F_STORE.ALL_ROUTE_DETAILS')
            ->select(
                DB::raw('TRIM(ROUTE_ID)      AS route_id'),
                DB::raw('TRIM(ROUTE_PATH)    AS route_path'),
                DB::raw('TRIM(MENU_CHILD_ID) AS menu_child_id'),
                DB::raw('TRIM(COMPONENT)     AS component')
            )
            ->whereRaw('TRIM(MENU_CHILD_ID) = ?', [$menuId])
            ->orderBy('ROUTE_ID')
            ->get();

        $userInfo = DB::table('F_STORE.ALL_USER_INFO')
            ->whereRaw('TRIM(USER_ID) = ?', [$userId])
            ->select(DB::raw('TRIM(USER_GROUP_ID) AS user_group_id'))
            ->first();

        $groupId = $userInfo ? trim($userInfo->user_group_id) : '';

        $userRoutePerms = DB::table('F_STORE.ALL_USER_SUB_DETAILS')
            ->select(
                DB::raw('TRIM(SUB_MENU_ID) AS sub_menu_id'),
                DB::raw('TRIM(ENABLED)     AS enabled')
            )
            ->whereRaw('TRIM(USER_ID)      = ?', [$userId])
            ->whereRaw('TRIM(MENU_ITEM_ID) = ?', [$menuId])
            ->get()
            ->keyBy('sub_menu_id')
            ->map(fn($r) => $r->enabled === 'Y');

        $hasUserRouteOverrides = $userRoutePerms->isNotEmpty();

        $groupRoutePerms = DB::table('F_STORE.ALL_USER_SUB_DETAILS')
            ->select(
                DB::raw('TRIM(SUB_MENU_ID) AS sub_menu_id'),
                DB::raw('TRIM(ENABLED)     AS enabled')
            )
            ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
            ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
            ->whereRaw("(USER_ID IS NULL OR TRIM(USER_ID) = '')")
            ->get()
            ->keyBy('sub_menu_id')
            ->map(fn($r) => $r->enabled === 'Y');

        $result = $routes->map(function ($route) use (
            $userRoutePerms, $groupRoutePerms, $hasUserRouteOverrides
        ) {
            $rid = $route->route_id;

            if ($hasUserRouteOverrides) {
                $enabled = isset($userRoutePerms[$rid]) ? $userRoutePerms[$rid] : ($groupRoutePerms[$rid] ?? false);
                $source  = isset($userRoutePerms[$rid]) ? 'user' : 'group';
            } else {
                $enabled = $groupRoutePerms[$rid] ?? false;
                $source  = 'group';
            }

            return [
                'route_id'      => $rid,
                'route_path'    => $route->route_path,
                'menu_child_id' => $route->menu_child_id,
                'component'     => $route->component,
                'enabled'       => $enabled,
                'source'        => $source,
            ];
        });

        return response()->json([
            'routes'  => $result,
            'menu_id' => $menuId,
        ]);
    }

    public function save(Request $request, $userId)
    {
        $userId  = trim((string) $userId);
        $groupId = trim((string) $request->input('user_group_id'));

        $raw         = $request->input('permissions', '[]');
        $permissions = is_array($raw) ? $raw : (json_decode($raw, true) ?? []);

        // ── Check once: does this user already have ANY rows in ALL_USER_GROUP_DETAILS? ──
        // If YES → only UPDATE existing rows, never INSERT new ones (skip missing menus).
        // If NO  → this is a fresh save, INSERT all rows.
        $userHasGroupDetails = DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
            ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
            ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
            ->exists();

        foreach ($permissions as $menuId => $data) {
            $menuId  = trim((string) $menuId);
            $enabled = ($data['enabled'] ?? false) ? 'Y' : 'N';

            // ── ALL_USER_GROUP_DETAILS: menu-level ────────────────────────────
            $menuRowExists = DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
                ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                ->exists();

            if ($menuRowExists) {
                // Row exists → always UPDATE
                DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
                    ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                    ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                    ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                    ->update([
                        'ENABLED'     => $enabled,
                        'UPDATE_BY'   => auth()->id() ?? 'USER',
                        'UPDATE_DATE' => now(),
                    ]);
            } elseif (!$userHasGroupDetails) {
                // No rows at all for this user → fresh INSERT
                DB::table('F_STORE.ALL_USER_GROUP_DETAILS')->insert([
                    'MENU_ITEM_ID'  => $menuId,
                    'USER_GROUP_ID' => $groupId,
                    'USER_ID'       => $userId,
                    'ENABLED'       => $enabled,
                    'INSERT_DATE'   => now(),
                    'INSERT_BY'     => auth()->id() ?? 'USER',
                    'UPDATE_BY'     => auth()->id() ?? 'USER',
                    'UPDATE_DATE'   => now(),
                ]);
            }
            // else: user has other rows but NOT this menu → skip (do not insert)

            // ── ALL_USER_SUB_DETAILS: route-level ─────────────────────────────
            // Same rule: if user already has sub-detail rows, only update/delete
            // existing ones. Never insert new route rows for an existing user.
            $userHasSubDetails = DB::table('F_STORE.ALL_USER_SUB_DETAILS')
                ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                ->exists();

            foreach ($data['routes'] ?? [] as $routeId => $routeEnabled) {
                $routeId = trim((string) $routeId);

                $routeRowExists = DB::table('F_STORE.ALL_USER_SUB_DETAILS')
                    ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                    ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                    ->whereRaw('TRIM(SUB_MENU_ID)   = ?', [$routeId])
                    ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                    ->exists();

                if (!$routeEnabled) {
                    // Toggle OFF → DELETE if row exists
                    if ($routeRowExists) {
                        DB::table('F_STORE.ALL_USER_SUB_DETAILS')
                            ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                            ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                            ->whereRaw('TRIM(SUB_MENU_ID)   = ?', [$routeId])
                            ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                            ->delete();
                    }
                    // Row does not exist and toggled off → nothing to do
                    continue;
                }

                // Toggle ON
                if ($routeRowExists) {
                    // Row exists → UPDATE enabled flag
                    DB::table('F_STORE.ALL_USER_SUB_DETAILS')
                        ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
                        ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
                        ->whereRaw('TRIM(SUB_MENU_ID)   = ?', [$routeId])
                        ->whereRaw('TRIM(MENU_ITEM_ID)  = ?', [$menuId])
                        ->update([
                            'ENABLED'     => 'Y',
                            'UPDATE_BY'   => auth()->id() ?? 'USER',
                            'UPDATE_DATE' => now(),
                        ]);
                } elseif (!$userHasSubDetails) {
                    // No sub-detail rows yet for this user+menu → fresh INSERT
                    $route = DB::table('F_STORE.ALL_ROUTE_DETAILS')
                        ->whereRaw('TRIM(ROUTE_ID) = ?', [$routeId])
                        ->select(
                            DB::raw('TRIM(ROUTE_PATH) AS route_path'),
                            DB::raw('TRIM(COMPONENT)  AS component')
                        )
                        ->first();

                    DB::table('F_STORE.ALL_USER_SUB_DETAILS')->insert([
                        'USER_GROUP_ID' => $groupId,
                        'SUB_MENU_ID'   => $routeId,
                        'USER_ID'       => $userId,
                        'MENU_ITEM_ID'  => $menuId,
                        'SUB_MENU_NAME' => $route?->component ?? $routeId,
                        'ROUTE'         => $route?->route_path ?? '',
                        'ENABLED'       => 'Y',
                        'INSERT_DATE'   => now(),
                        'INSERT_BY'     => auth()->id() ?? 'USER',
                    ]);
                }
                // else: user has sub-detail rows but not this route → skip
            }
        }

        return response()->json(['success' => true]);
    }

    public function reset(Request $request, $userId)
    {
        $userId  = trim((string) $userId);
        $groupId = trim((string) $request->input('user_group_id'));

        DB::table('F_STORE.ALL_USER_GROUP_DETAILS')
            ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
            ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
            ->delete();

        DB::table('F_STORE.ALL_USER_SUB_DETAILS')
            ->whereRaw('TRIM(USER_GROUP_ID) = ?', [$groupId])
            ->whereRaw('TRIM(USER_ID)       = ?', [$userId])
            ->delete();

        return response()->json(['success' => true]);
    }
}