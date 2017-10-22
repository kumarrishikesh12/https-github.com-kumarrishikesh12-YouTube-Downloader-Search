<?php

/*
 * PHP script for downloading videos from youtube
 * Copyright (C) 2012-2017  John Eckman
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, see <http://www.gnu.org/licenses/>.
 */

namespace YoutubeDownloader\Application;

use Exception;

/**
 * The download controller
 */
class DownloadController extends ControllerAbstract
{
	/**
	 * Excute the Controller
	 *
	 * @param string $route
	 * @param YoutubeDownloader\Application\App $app
	 *
	 * @return void
	 */
	public function execute()
	{
		$config = $this->get('config');
		$toolkit = $this->get('toolkit');

		// Check download token
		if (empty($_GET['mime']) OR empty($_GET['token']))
		{
			$this->responseWithErrorMessage('Invalid download token 8{');
		}

		// Set operation params
		$mime = filter_var($_GET['mime']);
		$ext = str_replace(['/', 'x-'], '', strstr($mime, '/'));
		$url = base64_decode(filter_var($_GET['token']));
		$name = urldecode($_GET['title']) . '.' . $ext;

		// Fetch and serve
		if ($url)
		{
			// prevent unauthorized download
			if($config->get('VideoLinkMode') === "direct" and !isset($_GET['getmp3']))
			{
				$this->responseWithErrorMessage(
					'VideoLinkMode: proxy download not enabled'
				);
			}

			if(
				$config->get('VideoLinkMode') !== "direct"
				and ! isset($_GET['getmp3'])
				and ! preg_match('@https://[^\.]+\.googlevideo.com/@', $url)
			)
			{
				$this->responseWithErrorMessage('unauthorized access (^_^)');
			}

			// check if request for mp3 download
			if(isset($_GET['getmp3']))
			{
				if( ! $config->get('MP3Enable') )
				{
					$this->responseWithErrorMessage(
						'Option for MP3 download is not enabled.'
					);
				}

				$youtube_provider = \YoutubeDownloader\Provider\Youtube\Provider::createFromConfigAndToolkit(
					$config,
					$toolkit
				);

				if ( $youtube_provider instanceOf \YoutubeDownloader\Cache\CacheAware )
				{
					$youtube_provider->setCache($this->get('cache'));
				}

				if ( $youtube_provider instanceOf \YoutubeDownloader\Logger\LoggerAware )
				{
					$youtube_provider->setLogger($this->get('logger'));
				}

				$video_info = $youtube_provider->provide($url);

				try
				{
					$mp3_info = $toolkit->getDownloadMP3($video_info, $config);
				}
				catch (Exception $e)
				{
					$message = $e->getMessage();

					if($config->get('debug') && $e->getPrevious() !== null)
					{
						$message .= " " . $e->getPrevious()->getMessage();
					}

					$this->responseWithErrorMessage($message);
				}

				$url = $mp3_info['mp3'];
			}

			if(isset($mp3_info['mp3']))
			{
				$size = filesize($mp3_info['mp3']);
			}
			else
			{
				$size = $this->getSize($url, $config, $toolkit);
			}

			// Generate the server headers
			header('Content-Type: "' . $mime . '"');
			header('Content-Disposition: attachment; filename="' . $name . '"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Content-Length: '.$size);
			header('Pragma: no-cache');

			if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
			{
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			}

			readfile($url);
			exit;
		}

		// Not found
		$this->responseWithErrorMessage('File not found 8{');
	}
}
