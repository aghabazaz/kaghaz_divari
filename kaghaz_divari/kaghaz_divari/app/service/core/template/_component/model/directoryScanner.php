<?php

/**
 * Scans directory content recursive and returns its structure.
 */
class directoryScanner
{

    public function scanDirRecursive($path)
    {
        return $this->getDirStructureRecursive(new DirectoryIterator($path)) ;
    }

    private function getDirStructureRecursive(DirectoryIterator $dir)
    {
        $data = array () ;
        foreach ( $dir as $node )
        {
            if ( $node->isDir() && ! $node->isDot() )
            {
                $data[ $node->getFilename() ] = $this->getDirStructureRecursive(new DirectoryIterator($node->getPathname())) ;
            }
            else if ( $node->isFile() )
            {
                $data[] = $node->getFilename() ;
            }
            
        }
        return $data ;
    }

}
