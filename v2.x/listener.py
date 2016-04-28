import time
import sys
import subprocess
from watchdog.observers import Observer  
from watchdog.events import PatternMatchingEventHandler  

class FileListenerHandler(PatternMatchingEventHandler):
    patterns = ["*.php", "*.tpl", ".css", ".js"]

    def process(self, event):
        """
        event.event_type 
            'modified' | 'created' | 'moved' | 'deleted'
        event.is_directory
            True | False
        event.src_path
            path/to/observed/file
        """
        # the file will be processed there
        accepted_events = ['modified', 'moved', 'created']
        if event.event_type in accepted_events:
            print event.src_path, event.event_type
            move_file(event.src_path)  

    def on_modified(self, event):
        self.process(event)

    def on_created(self, event):
        self.process(event)


def move_file(initial_path):
    position = initial_path[2:].find('/') + 2
    start_path = '/Users/bobemfica/Documents/projetos/cart-opencart/v2.x%s' % initial_path[1:]
    final_path = '/Applications/MAMP/htdocs/oc21%s' % initial_path[position:]
    print('moving file %s to %s' % (start_path, final_path))
    cmd_move = 'ditto -V %s %s ' % (start_path, final_path)
    print(subprocess.call(cmd_move, shell=True))


if __name__ == '__main__':
    args = sys.argv[1:]
    observer = Observer()
    observer.schedule(FileListenerHandler(), recursive=True, path=args[0] if args else '.')
    observer.start()
    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        observer.stop()

    observer.join()