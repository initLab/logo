LOGO_ORIGINAL=img/logo-original.png
LOGO_ORIGINAL_DEBUG=img/logo-original-debug.png
LOGO_JSON=src/logo.json
LOGO_PIXEL_MAP=txt/logo-pixel-map.txt
LOGO_PNG_INDEXED=img/logo-indexed.png
LOGO_SVG_RECT=img/logo-rect.svg
LOGO_SVG_PATH=img/logo-path.svg

$(LOGO_JSON): $(LOGO_ORIGINAL)
	./bin/original-to-json.php

$(LOGO_ORIGINAL_DEBUG): $(LOGO_ORIGINAL)
	./bin/original-to-json.php 1

$(LOGO_PIXEL_MAP): $(LOGO_JSON)
	./bin/json-to-pixel-map.php

$(LOGO_PNG_INDEXED): $(LOGO_JSON)
	./bin/json-to-indexed-png.php

$(LOGO_SVG_RECT): $(LOGO_JSON)
	./bin/json-to-svg-rect.php

$(LOGO_SVG_PATH): $(LOGO_JSON)
	./bin/json-to-svg-path.php

all: $(LOGO_JSON) $(LOGO_PNG_INDEXED) $(LOGO_PIXEL_MAP) $(LOGO_PNG_INDEXED) $(LOGO_SVG_RECT) $(LOGO_SVG_PATH)

clean:
	rm $(LOGO_ORIGINAL_DEBUG) $(LOGO_JSON) $(LOGO_PNG_INDEXED) $(LOGO_PIXEL_MAP) $(LOGO_PNG_INDEXED) $(LOGO_SVG_RECT) $(LOGO_SVG_PATH)
