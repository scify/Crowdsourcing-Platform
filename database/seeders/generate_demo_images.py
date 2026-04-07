#!/usr/bin/env python3
"""
Generate showcase images for the Crowdsourcing Platform demo installation.

Produces:
  - public/images/projects/{slug}/logo-bg.webp   (1792×1024 hero background)
  - public/images/projects/{slug}/logo.webp       (1024×1024 square logo)
  - public/images/problems/problem-{n}.webp       (800×534 problem cards)
  - public/images/solutions/solution-{n}.webp     (800×534 solution cards)
"""

import os
import math
from PIL import Image, ImageDraw, ImageFont

BASE = "/home/paul/projects/Crowdsourcing-Platform/public/images"
FONT_BOLD    = "/usr/share/fonts/truetype/ubuntu/Ubuntu-B.ttf"
FONT_REGULAR = "/usr/share/fonts/truetype/ubuntu/Ubuntu-R.ttf"


# ─── helpers ──────────────────────────────────────────────────────────────────

def hex2rgb(h):
    h = h.lstrip('#')
    return tuple(int(h[i:i+2], 16) for i in (0, 2, 4))

def darken(rgb, factor=0.6):
    return tuple(max(0, int(c * factor)) for c in rgb)

def lighten(rgb, factor=1.35):
    return tuple(min(255, int(c * factor)) for c in rgb)

def blend(c1, c2, t):
    return tuple(int(c1[i] + (c2[i]-c1[i]) * t) for i in range(3))

def make_gradient_h(width, height, c1, c2):
    """Fast horizontal gradient via 1-pixel strip resize."""
    strip = Image.new('RGB', (width, 1))
    sd = strip.load()
    for x in range(width):
        sd[x, 0] = blend(c1, c2, x / max(width-1, 1))
    return strip.resize((width, height), Image.BILINEAR)

def make_gradient_v(width, height, c1, c2):
    strip = Image.new('RGB', (1, height))
    sd = strip.load()
    for y in range(height):
        sd[0, y] = blend(c1, c2, y / max(height-1, 1))
    return strip.resize((width, height), Image.BILINEAR)

def overlay_alpha(base, color, alpha):
    """Paint a solid colour at given alpha (0-255) over base."""
    overlay = Image.new('RGBA', base.size, color + (alpha,))
    result = base.convert('RGBA')
    result = Image.alpha_composite(result, overlay)
    return result.convert('RGB')

def get_font(path, size):
    try:
        return ImageFont.truetype(path, size)
    except Exception:
        return ImageFont.load_default()

def wrap_text(text, font, max_width, draw):
    """Word-wrap text to fit max_width pixels."""
    words = text.split()
    lines, line = [], []
    for w in words:
        test = ' '.join(line + [w])
        bbox = draw.textbbox((0, 0), test, font=font)
        if bbox[2] <= max_width or not line:
            line.append(w)
        else:
            lines.append(' '.join(line))
            line = [w]
    if line:
        lines.append(' '.join(line))
    return lines

def draw_centered_text(draw, lines, font, center_x, start_y, color, line_gap=8):
    y = start_y
    for line in lines:
        bbox = draw.textbbox((0, 0), line, font=font)
        w = bbox[2] - bbox[0]
        draw.text((center_x - w//2, y), line, font=font, fill=color)
        y += (bbox[3] - bbox[1]) + line_gap
    return y


# ─── dot/hex pattern ──────────────────────────────────────────────────────────

def draw_dot_grid(draw, width, height, dot_color, spacing=60, radius=3):
    for y in range(0, height + spacing, spacing):
        for x in range(0, width + spacing, spacing):
            draw.ellipse([x-radius, y-radius, x+radius, y+radius], fill=dot_color)

def draw_hex_pattern(draw, width, height, color, size=45):
    """Draw a hex grid overlay."""
    h = size * math.sqrt(3)
    col = 0
    x = 0
    while x < width + size * 2:
        y_offset = (h / 2) if col % 2 else 0
        y = -h + y_offset
        while y < height + h:
            cx, cy = x, y
            pts = [(cx + size * math.cos(math.radians(60*i - 30)),
                    cy + size * math.sin(math.radians(60*i - 30))) for i in range(6)]
            draw.polygon(pts, outline=color, fill=None)
            y += h
        x += size * 1.5
        col += 1


# ─── big decorative shapes ────────────────────────────────────────────────────

def draw_circle_deco(img, cx, cy, r, color_rgb, alpha=40):
    overlay = Image.new('RGBA', img.size, (0, 0, 0, 0))
    d = ImageDraw.Draw(overlay)
    d.ellipse([cx-r, cy-r, cx+r, cy+r], fill=color_rgb + (alpha,))
    base = img.convert('RGBA')
    return Image.alpha_composite(base, overlay).convert('RGB')

def draw_arc_deco(img, cx, cy, r, color_rgb, width=8, alpha=60):
    overlay = Image.new('RGBA', img.size, (0, 0, 0, 0))
    d = ImageDraw.Draw(overlay)
    d.arc([cx-r, cy-r, cx+r, cy+r], 0, 270,
          fill=color_rgb + (alpha,), width=width)
    base = img.convert('RGBA')
    return Image.alpha_composite(base, overlay).convert('RGB')


# ─── project-specific icons ───────────────────────────────────────────────────

def draw_icon_leaf(draw, cx, cy, size, color):
    """Simple leaf: two arcs forming a teardrop."""
    d = size // 2
    # stem
    draw.line([(cx, cy + d//2), (cx, cy + d + 10)], fill=color, width=max(3, size//20))
    # leaf body (ellipse rotated via bounding box)
    draw.ellipse([cx - d//2, cy - d, cx + d//2, cy + d//4], fill=color)
    # midrib
    draw.line([(cx, cy - d + 4), (cx, cy + d//4)], fill=lighten(color, 1.3), width=max(2, size//30))

def draw_icon_city(draw, cx, cy, size, color):
    """City skyline from rectangles."""
    s = size // 2
    buildings = [
        (-s,      10, -s//2,    s),     # left small
        (-s//2,    0, -s//5,    s),     # left tall
        (-s//5,   15,  s//5,    s),     # centre short
        ( s//5,  -s//3,  s//2,   s),   # right tall
        ( s//2,    5,   s,      s),    # far right
    ]
    for bx1, by1, bx2, by2 in buildings:
        draw.rectangle([cx+bx1, cy+by1, cx+bx2, cy+by2], fill=color)
    # ground line
    draw.rectangle([cx-s, cy+s, cx+s, cy+s+4], fill=color)

def draw_icon_network(draw, cx, cy, size, color):
    """Network: nodes connected by lines."""
    r = size // 6
    nodes = [
        (cx,        cy - size//2 + r),        # top
        (cx - size//2 + r, cy + size//4),     # bottom-left
        (cx + size//2 - r, cy + size//4),     # bottom-right
        (cx,        cy),                       # centre
    ]
    for i, (nx, ny) in enumerate(nodes):
        for j, (mx, my) in enumerate(nodes):
            if i < j:
                draw.line([(nx, ny), (mx, my)], fill=color, width=max(2, size//30))
    for nx, ny in nodes:
        draw.ellipse([nx-r, ny-r, nx+r, ny+r], fill=color)

def draw_icon_circuit(draw, cx, cy, size, color):
    """Circuit board pattern: lines + solder points."""
    s = size // 2
    lw = max(2, size // 25)
    pts = [
        ((cx - s, cy),       (cx - s//3, cy)),
        ((cx - s//3, cy),    (cx - s//3, cy - s//2)),
        ((cx - s//3, cy - s//2), (cx + s//3, cy - s//2)),
        ((cx + s//3, cy - s//2), (cx + s//3, cy + s//3)),
        ((cx + s//3, cy + s//3), (cx + s,    cy + s//3)),
        ((cx - s//3, cy),    (cx + s//4, cy)),
        ((cx + s//4, cy),    (cx + s//4, cy + s//2)),
        ((cx + s//4, cy + s//2), (cx + s,  cy + s//2)),
    ]
    for p1, p2 in pts:
        draw.line([p1, p2], fill=color, width=lw)
    solder = [
        (cx - s, cy),
        (cx - s//3, cy),
        (cx - s//3, cy - s//2),
        (cx + s//3, cy - s//2),
        (cx + s//3, cy + s//3),
        (cx + s, cy + s//3),
        (cx + s//4, cy),
        (cx + s//4, cy + s//2),
        (cx + s, cy + s//2),
    ]
    sr = max(4, size // 18)
    for sx, sy in solder:
        draw.ellipse([sx-sr, sy-sr, sx+sr, sy+sr], fill=color)

ICON_FUNCS = {
    'leaf':    draw_icon_leaf,
    'city':    draw_icon_city,
    'network': draw_icon_network,
    'circuit': draw_icon_circuit,
}


# ─── project logo-bg (1792×1024) ──────────────────────────────────────────────

def make_logo_bg(cfg, out_path):
    W, H = 1792, 1024
    c  = cfg['color']
    cd = darken(c, 0.45)
    cl = darken(c, 0.70)

    # diagonal gradient: darker bottom-left → lighter top-right
    img = make_gradient_h(W, H, cd, cl)

    # secondary vertical darkening at bottom
    vgrad = make_gradient_v(W, H, (0, 0, 0), (0, 0, 0))
    mask = Image.new('L', (W, H))
    md = ImageDraw.Draw(mask)
    for y in range(H):
        alpha = int(100 * (y / H) ** 1.5)
        md.line([(0, y), (W, y)], fill=alpha)
    img.paste(Image.new('RGB', (W, H), (0, 0, 0)), mask=mask)

    # hex grid at very low opacity
    hex_overlay = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    hd = ImageDraw.Draw(hex_overlay)
    draw_hex_pattern(hd, W, H, lighten(c, 1.5) + (18,), size=55)
    img = Image.alpha_composite(img.convert('RGBA'), hex_overlay).convert('RGB')

    # large decorative circles
    img = draw_circle_deco(img, W - 200, -150, 520, lighten(c, 1.6), alpha=30)
    img = draw_circle_deco(img, W - 200, -150, 380, lighten(c, 1.8), alpha=18)
    img = draw_circle_deco(img, -50, H + 50, 340, lighten(c, 1.4), alpha=20)
    img = draw_arc_deco(img, W//2, H//2, 420, lighten(c, 2.0), width=2, alpha=25)

    # dark gradient panel on left for text legibility
    panel = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    pd = ImageDraw.Draw(panel)
    for x in range(W // 2):
        a = int(90 * (1 - x / (W // 2)))
        pd.line([(x, 0), (x, H)], fill=(0, 0, 0, a))
    img = Image.alpha_composite(img.convert('RGBA'), panel).convert('RGB')

    draw = ImageDraw.Draw(img)

    # accent bar
    bar_h = 6
    bar_y = H // 2 - 85
    draw.rectangle([80, bar_y, 80 + 60, bar_y + bar_h], fill=(255, 255, 255))

    # project name (large, two lines)
    font_title = get_font(FONT_BOLD, 82)
    title_lines = cfg['name'].split('\n')
    y = bar_y + bar_h + 20
    for line in title_lines:
        bbox = draw.textbbox((0, 0), line, font=font_title)
        # subtle shadow
        draw.text((82, y + 3), line, font=font_title, fill=(0, 0, 0, 120))
        draw.text((80, y), line, font=font_title, fill=(255, 255, 255))
        y += (bbox[3] - bbox[1]) + 10

    # divider
    draw.rectangle([80, y + 12, 80 + 200, y + 14], fill=(255, 255, 255, 160))

    # tagline
    font_tag = get_font(FONT_REGULAR, 30)
    draw.text((80, y + 24), cfg['tagline'], font=font_tag,
              fill=(255, 255, 255, 200))

    # icon (bottom-right quadrant)
    icon_cx, icon_cy = int(W * 0.78), H // 2
    icon_size = 180
    icon_color = lighten(c, 1.8)
    ICON_FUNCS[cfg['icon']](draw, icon_cx, icon_cy, icon_size, icon_color + (70,))

    img.save(out_path, 'WEBP', quality=88)
    print(f"  ✓ {out_path}")


# ─── project logo (1024×1024) ─────────────────────────────────────────────────

def make_logo(cfg, out_path):
    W = H = 1024
    c  = cfg['color']
    cd = darken(c, 0.55)
    cl = lighten(c, 1.3)

    # radial-ish gradient: top-left lighter, bottom-right darker
    img = make_gradient_h(W, H, cl, cd)
    vg  = make_gradient_v(W, H, lighten(c, 1.1), darken(c, 0.65))

    # blend the two gradients 50/50
    img = Image.blend(img, vg, 0.5)

    # dot pattern
    dot_overlay = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    dd = ImageDraw.Draw(dot_overlay)
    draw_dot_grid(dd, W, H, lighten(c, 2.0) + (20,), spacing=50, radius=2)
    img = Image.alpha_composite(img.convert('RGBA'), dot_overlay).convert('RGB')

    # large circle ring as frame element
    img = draw_arc_deco(img, W//2, H//2, 420, (255, 255, 255), width=4, alpha=35)

    draw = ImageDraw.Draw(img)

    # icon centred upper half
    ICON_FUNCS[cfg['icon']](draw, W//2, H//2 - 80, 240, (255, 255, 255))

    # project abbreviated name
    abbrev = cfg['name'].replace('\n', ' ')
    font_main = get_font(FONT_BOLD, 58)
    font_sub  = get_font(FONT_REGULAR, 32)

    # main name (may be two lines if split at \n)
    lines = cfg['name'].split('\n')
    y = H//2 + 100
    for line in lines:
        bbox = draw.textbbox((0, 0), line, font=font_main)
        w = bbox[2] - bbox[0]
        draw.text((W//2 - w//2 + 2, y + 2), line, font=font_main, fill=(0, 0, 0, 80))
        draw.text((W//2 - w//2, y), line, font=font_main, fill=(255, 255, 255))
        y += (bbox[3] - bbox[1]) + 8

    # thin divider
    draw.rectangle([W//2 - 80, y + 6, W//2 + 80, y + 8],
                   fill=(255, 255, 255, 160))

    img.save(out_path, 'WEBP', quality=88)
    print(f"  ✓ {out_path}")


# ─── problem / solution card (800×534) ────────────────────────────────────────

def make_card(title, subtitle, color_hex, icon_key, out_path, label=""):
    W, H = 800, 534
    c  = hex2rgb(color_hex)
    cd = darken(c, 0.50)
    cl = darken(c, 0.80)

    img = make_gradient_h(W, H, cd, cl)

    # subtle hex overlay
    hex_overlay = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    hd = ImageDraw.Draw(hex_overlay)
    draw_hex_pattern(hd, W, H, lighten(c, 1.5) + (15,), size=40)
    img = Image.alpha_composite(img.convert('RGBA'), hex_overlay).convert('RGB')

    # decorative circle top-right
    img = draw_circle_deco(img, W + 60, -80, 320, lighten(c, 1.6), alpha=28)

    # bottom gradient for text area
    panel = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    pd = ImageDraw.Draw(panel)
    for y in range(H // 2, H):
        a = int(160 * ((y - H // 2) / (H // 2)) ** 0.8)
        pd.line([(0, y), (W, y)], fill=(0, 0, 0, a))
    img = Image.alpha_composite(img.convert('RGBA'), panel).convert('RGB')

    draw = ImageDraw.Draw(img)

    # icon centred in upper portion
    icon_fn = ICON_FUNCS.get(icon_key, draw_icon_network)
    icon_fn(draw, W // 2, H // 3, 120, (255, 255, 255))

    # badge/label top-left
    if label:
        font_badge = get_font(FONT_BOLD, 22)
        draw.rectangle([20, 20, 20 + len(label)*14 + 16, 54],
                       fill=(255, 255, 255, 40))
        draw.text((28, 24), label, font=font_badge, fill=(255, 255, 255))

    # title
    font_title = get_font(FONT_BOLD, 36)
    font_sub   = get_font(FONT_REGULAR, 22)
    margin = 30
    text_lines = wrap_text(title, font_title, W - margin * 2, draw)
    y = H - 110
    for line in text_lines:
        bbox = draw.textbbox((0, 0), line, font=font_title)
        w = bbox[2] - bbox[0]
        draw.text((margin, y), line, font=font_title, fill=(255, 255, 255))
        y += (bbox[3] - bbox[1]) + 4

    # subtitle / description snippet
    if subtitle:
        sub_lines = wrap_text(subtitle, font_sub, W - margin * 2, draw)[:2]
        for line in sub_lines[:1]:
            draw.text((margin, y + 4), line, font=font_sub,
                      fill=(255, 255, 255, 180))

    img.save(out_path, 'WEBP', quality=85)
    print(f"  ✓ {out_path}")


# ─── project definitions ──────────────────────────────────────────────────────

PROJECTS = [
    {
        'slug':    'climate-action-survey',
        'color':   hex2rgb('#2d7a4f'),
        'name':    'CLIMATE ACTION\nSURVEY',
        'tagline': 'Your voice shapes our climate future',
        'icon':    'leaf',
    },
    {
        'slug':    'urban-innovation-hub',
        'color':   hex2rgb('#e67e22'),
        'name':    'URBAN\nINNOVATION HUB',
        'tagline': 'Solving city challenges together',
        'icon':    'city',
    },
    {
        'slug':    'digital-democracy',
        'color':   hex2rgb('#2980b9'),
        'name':    'DIGITAL\nDEMOCRACY',
        'tagline': 'Empowering civic participation',
        'icon':    'network',
    },
    {
        'slug':    'smart-cities-2030',
        'color':   hex2rgb('#6c3483'),
        'name':    'SMART CITIES\n2030',
        'tagline': 'Building the cities of tomorrow',
        'icon':    'circuit',
    },
]

PROBLEMS = [
    # project 2 — urban (orange)
    {'id': 1, 'title': 'City Centre Parking Shortage',          'color': '#e67e22', 'icon': 'city',    'label': 'PROBLEM'},
    {'id': 2, 'title': 'Inadequate Cycling Infrastructure',     'color': '#e67e22', 'icon': 'city',    'label': 'PROBLEM'},
    {'id': 3, 'title': 'Urban Heat Islands',                    'color': '#e67e22', 'icon': 'leaf',    'label': 'PROBLEM'},
    # project 3 — digital (blue)
    {'id': 4, 'title': 'Low Voter Engagement in Local Elections','color': '#2980b9', 'icon': 'network', 'label': 'PROBLEM'},
    {'id': 5, 'title': 'Digital Exclusion of Elderly Citizens', 'color': '#2980b9', 'icon': 'network', 'label': 'PROBLEM'},
    # project 4 — smart cities (purple)
    {'id': 6, 'title': 'Inefficient Waste Collection Routes',   'color': '#6c3483', 'icon': 'circuit', 'label': 'PROBLEM'},
    {'id': 7, 'title': 'Static Street Lighting Wastes Energy',  'color': '#6c3483', 'icon': 'circuit', 'label': 'PROBLEM'},
]

SOLUTIONS = [
    # problems 1-3 (urban, orange)
    {'id':  1, 'title': 'Expand Park-and-Ride Scheme',               'color': '#e67e22', 'icon': 'city',    'label': 'SOLUTION'},
    {'id':  2, 'title': 'Introduce Dynamic Parking Pricing',          'color': '#e67e22', 'icon': 'city',    'label': 'SOLUTION'},
    {'id':  3, 'title': 'Build Protected Cycle Lanes on Main Roads',  'color': '#e67e22', 'icon': 'city',    'label': 'SOLUTION'},
    {'id':  4, 'title': 'Launch City-Wide Bike Sharing Program',      'color': '#e67e22', 'icon': 'leaf',    'label': 'SOLUTION'},
    {'id':  5, 'title': 'Create Urban Greening Corridors',            'color': '#e67e22', 'icon': 'leaf',    'label': 'SOLUTION'},
    # problems 4-5 (digital, blue)
    {'id':  6, 'title': 'Streamlined Digital Voter Registration',     'color': '#2980b9', 'icon': 'network', 'label': 'SOLUTION'},
    {'id':  7, 'title': 'Civic Education Programme in Schools',       'color': '#2980b9', 'icon': 'network', 'label': 'SOLUTION'},
    {'id':  8, 'title': 'Free Digital Literacy Hubs at Libraries',    'color': '#2980b9', 'icon': 'network', 'label': 'SOLUTION'},
    # problems 6-7 (smart cities, purple)
    {'id':  9, 'title': 'IoT Fill-Level Sensors in Bins',             'color': '#6c3483', 'icon': 'circuit', 'label': 'SOLUTION'},
    {'id': 10, 'title': 'Public Waste Data Dashboard',                'color': '#6c3483', 'icon': 'circuit', 'label': 'SOLUTION'},
    {'id': 11, 'title': 'Adaptive LED Lighting with Motion Sensors',  'color': '#6c3483', 'icon': 'circuit', 'label': 'SOLUTION'},
]


# ─── main ─────────────────────────────────────────────────────────────────────

if __name__ == '__main__':
    # Project images
    for p in PROJECTS:
        d = f"{BASE}/projects/{p['slug']}"
        os.makedirs(d, exist_ok=True)
        print(f"\n[{p['slug']}]")
        make_logo_bg(p, f"{d}/logo-bg.webp")
        make_logo(p,    f"{d}/logo.webp")

    # Problem images
    os.makedirs(f"{BASE}/problems", exist_ok=True)
    print("\n[problems]")
    for pr in PROBLEMS:
        make_card(pr['title'], '', pr['color'], pr['icon'],
                  f"{BASE}/problems/problem-{pr['id']}.webp", pr['label'])

    # Solution images
    os.makedirs(f"{BASE}/solutions", exist_ok=True)
    print("\n[solutions]")
    for sl in SOLUTIONS:
        make_card(sl['title'], '', sl['color'], sl['icon'],
                  f"{BASE}/solutions/solution-{sl['id']}.webp", sl['label'])

    print("\nDone.")
